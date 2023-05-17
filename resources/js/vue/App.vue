<template>
    <div class="bg-white p-3 max-w-md mx-auto">
        <div class="ml-4 text-center">
            <h1 class="text-3xl font-bold">My Todo List</h1>

            <div class="mt-8">
                <div v-if="showArchivedList === false">
                    <button class="border-2 border-red-500 p-2 text-red-500"
                            @click="fetchItems('archived')"
                    >Show Archived
                    </button>
                </div>
                <div v-else>
                    <button class="border-2 border-red-500 p-2 text-red-500"
                            @click="fetchItems"
                    >Back to List
                    </button>
                </div>
            </div>

            <item-form v-on:create-new-item="storeItem($event)"></item-form>
        </div>

        <div class="mt-8">
            <ul>
                <item-list :items="items"
                ></item-list>
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
            items: [],
            showArchivedList: false,
            param: ''
        }
    },
    methods: {
        async fetchItems(dataType) {
            var URL = '/my-todo-list';
            if (dataType === 'archived') {
                URL = '/my-todo-list?param=archived';
                this.showArchivedList = true;
            } else {
                this.showArchivedList = false;
            }
            await axios.get(URL).then(resp => {
                this.items = resp.data.response.data
            }).catch(xhr => {
                // console.log(xhr)
            });

            return this.items;
        },
        async storeItem(item) {
            await axios.post('/my-todo-list/items/store', {
                _token: csrfToken,
                title: item.title
            }).then(resp => {
                // console.log(resp)
                if (resp.status == 200) {
                    item.title = '';
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

        this.$bus.$on('archive-item', async (itemId) => {
            await axios.post('/my-todo-list/items/archived/' + itemId)
                .then(resp => {
                    $_toastAlert('warning', resp.data.message)
                })
            await this.fetchItems();
        });

        this.$bus.$on('update-item', async (data) => {
            await axios.patch('/my-todo-list/items/update/' + data.item.id, {
                _token: csrfToken,
                title: data.item.title
            })
                .then(resp => {
                    data.item.title = '';
                    $_toastAlert('success', resp.data.message)
                    buttons.cancelBtn = false;
                    buttons.updateBtn = false;
                    buttons.addBtn = true;
                })
            await this.fetchItems();
        });

        this.$bus.$on('cancel-update', (data) => {
            data.item.title = '';
            buttons.cancelBtn = false;
            buttons.updateBtn = false;
            buttons.addBtn = true;
        });
    }
}
</script>
