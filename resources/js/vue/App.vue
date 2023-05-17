<style>
.btn {
    @apply font-bold py-2 px-4 rounded;
}
.btn-blue {
    @apply bg-blue-500 text-white;
}
.btn-blue:hover {
    @apply bg-blue-700;
}
</style>

<template>
    <div class="bg-white p-3 max-w-md mx-auto">
        <div class="ml-4 text-center">
            <h1 class="text-3xl font-bold">My Todo List</h1>

            <item-form v-on:create-new-item="storeItem($event)"></item-form>
        </div>

        <div class="mt-8">
            <ul>
                <item-list :items="items" :key="this.componentKey"></item-list>
            </ul>

            <div class="flex justify-between">
                <button class="btn btn-blue" v-if="hasLess" @click="previous">Previous</button>
                <button class="btn btn-blue" v-if="hasMore" @click="loadMore">Load More</button>

                <p v-else>No more items to load.</p>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";
import ItemForm from "./Item/ItemForm.vue";
import ItemList from "./Item/ItemList.vue";
import buttons from "@/buttons.js";

export default {
    components: {ItemForm, ItemList},
    computed: {
        buttons() {
            return buttons
        }
    },
    data() {
        return {
            items: [],
            currentPage: 1,
            perPage: 5,
            hasMore: true,
            hasLess: false,
        }
    },
    methods: {
        async fetchItems() {
            await axios.get(`/my-todo-list?page=${this.currentPage}`).then(resp => {
                this.items = resp.data.response;
            });
        },
        async storeItem(item) {
            await axios.post('/my-todo-list/store', {
                _token: csrfToken,
                title: item.title
            }).then(resp => {
                // console.log(resp)
                if (resp.status == 200) {
                    item.title = '';
                    item.errors = [];
                    $_toastAlert('success', resp.data.message)
                    this.fetchItems();
                }
            }).catch(xhr => {
                item.validationMessage = true
                item.errors = xhr.response.data
            });
        },
        async loadMore() {
            try {
                // increment the current page
                this.currentPage++;
                const response = await axios.get(`/my-todo-list?page=${this.currentPage}`);
                this.items = response.data.response;

                // check if page item length is equal to per page items
                this.hasMore = this.items.length === this.perPage;
                // check if current page is less than 1 to show previous button
                this.hasLess = this.currentPage > 1;
            } catch (error) {
                console.error('Error loading more items', error);
            }
        },
        async previous() {
            try {
                // decrement the current page
                this.currentPage--;
                const response = await axios.get(`/my-todo-list?page=${this.currentPage}`);
                this.items = response.data.response;

                // check if current page is less than 1 to hide previous button
                this.hasLess = this.currentPage > 1;
                // check if page item length is equal to per page items
                // if true show load more button
                this.hasMore = this.items.length === this.perPage;
            } catch (error) {
                console.error('Error loading items on previous', error);
            }
        }
    },
    created() {
        this.fetchItems();

        this.$bus.$on('delete-item', async (itemId) => {
            await axios.delete('/my-todo-list/destroy/' + itemId)
                .then(resp => {
                    $_toastAlert('warning', resp.data.message)
                })
            await this.fetchItems();
        });

        this.$bus.$on('update-item', async (data) => {
            await axios.patch('/my-todo-list/update/' + data.item.id, {
                _token: csrfToken,
                title: data.item.title
            })
                .then(resp => {
                    data.item.title = '';
                    $_toastAlert('success', resp.data.message)
                    buttons.cancelBtn = false;
                    buttons.updateBtn = false;
                    buttons.addBtn = true;
                }).catch(xhr => {
                    data.item.validationMessage = true
                    data.item.errors = xhr.response.data
                })
            await this.fetchItems();
        });

        this.$bus.$on('cancel-update', (data) => {
            data.item.title = '';
            data.item.validationMessage = false
            buttons.cancelBtn = false;
            buttons.updateBtn = false;
            buttons.addBtn = true;
        });
        buttons.cancelBtn = false;
        buttons.updateBtn = false;
        buttons.addBtn = true;
    }
}
</script>
