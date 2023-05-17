<template>
    <div class="bg-white p-3 max-w-md mx-auto">
        <div class="ml-4 text-center">
            <h1 class="text-3xl font-bold">My Todo List</h1>

            <item-form v-on:create-new-item="storeItem($event)"></item-form>
        </div>

        <div class="mt-8">
            <ul>
                <item-list :items="items"></item-list>
            </ul>
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
            items: []
        }
    },
    methods: {
        async fetchItems() {
            var URL = '/my-todo-list';
            await axios.get(URL).then(resp => {
                this.items = resp.data.response.data
            }).catch(xhr => {
                // console.log(xhr)
            });

            return this.items;
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
