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
    <div class="bg-white p-3 max-w-2xl mx-auto">
        <div class="text-center">
            <h1 class="text-3xl font-bold">My Todo List</h1>

            <item-form v-on:create-new-item="storeItem($event)"></item-form>
        </div>

        <div class="mt-8">
            <ul>
                <item-list v-if="items.length > 0" :items="items"></item-list>

                <li v-else class="my-1">No items found</li>
            </ul>

            <div class="flex"
                 :class="[(hasLess ? 'justify-between' : 'justify-end')]"
            >
                <button class="btn btn-blue" v-if="hasLess" @click="previous">Previous</button>
                <button class="btn btn-blue" v-if="hasMore && totalPages > 1" @click="next">Next</button>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";
import ItemForm from "./Item/ItemForm.vue";
import ItemList from "./Item/ItemList.vue";
import buttons from "@/buttons.js";
import {useRoute} from "vue-router";

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
            totalRecords: 0,
            totalPages: 0,
            hasNextPage: false
        }
    },
    methods: {
        async fetchItems() {
            await axios.get('/my-todo-list/items', {
                params: {
                    page: this.currentPage,
                    perPage: this.perPage
                }
            }).then(resp => {
                this.items = resp.data.response;
                this.totalRecords = resp.data.total;
                this.currentPage = resp.data.currentPage;
                this.totalPages = resp.data.totalPages;
                this.hasNextPage = resp.data.hasNextPage;
                if (this.currentPage === 1) {
                    this.hasMore = true;
                    this.hasLess = false;
                }
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
                    this.currentPage = 1;
                    this.fetchItems();
                }
            }).catch(xhr => {
                item.validationMessage = true
                item.errors = xhr.response.data
            });
        },
        async updateItem(data) {
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
                    this.fetchItems();
                }).catch(xhr => {
                    data.item.validationMessage = true
                    data.item.errors = xhr.response.data
                })
        },
        async deleteItem(itemId) {
            await axios.delete('/my-todo-list/destroy/' + itemId)
                .then(resp => {
                    $_toastAlert('warning', resp.data.message);
                    this.fetchItems();
                })
        },
        next() {
            if (this.currentPage < this.totalPages) {
                try {
                    // increment the current page
                    this.currentPage++;
                    this.fetchItems();

                    // check if current page is not equal to total page
                    // if true show next button or hide
                    this.hasMore = this.currentPage !== this.totalPages;
                    // check if current page is less than 1 to show previous button
                    this.hasLess = this.currentPage > 1;
                } catch (error) {
                    console.error('Error loading more items', error);
                }
            }
        },
        previous() {
            if (this.currentPage > 1) {
                try {
                    // decrement the current page
                    this.currentPage--;
                    this.fetchItems();

                    // check if current page is less than 1 to hide previous button
                    this.hasLess = this.currentPage > 1;
                    // check if current page is not equal to total page
                    // if true show next button or hide
                    this.hasMore = this.currentPage !== this.totalPages;
                } catch (error) {
                    console.error('Error loading items on previous', error);
                }
            }
        }
    },
    mounted() {
        this.fetchItems();
    },
    created() {
        this.$bus.$on('update-item', (data) => {
            this.updateItem(data);
        });

        this.$bus.$on('delete-item', (itemId) => {
            this.deleteItem(itemId);
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
