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
                           v-on:archive-item="archiveItem($event)"
                ></item-list>
            </ul>
        </div>
    </div>
</template>

<script>

import axios from "axios";
import ItemForm from "@/vue/Item/ItemForm.vue";
import ItemList from "@/vue/Item/ItemList.vue";

export default {
    components: {ItemForm, ItemList},
    data: function () {
        return {
            items: [],
            showArchivedList: false
        }
    },
    methods: {
        fetchItems(dataType) {
            var URL = '/my-todo-list/items';
            if (dataType == 'archived') {
                URL = '/my-todo-list/items?param=archived';
                this.showArchivedList = true;
            }
            axios.get(URL).then(resp => {
                this.items = resp.data.response.data
                // console.log(this.items)
            }).catch(xhr => {
                // console.log(xhr)
            });
        },
        storeItem: function (item) {
            axios.post('/my-todo-list/store', {
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
                this.validationMessage = true
                this.errors = xhr.response.data
                // console.log(this.errors)
            });
        },
        archiveItem: function (itemId) {
            axios.post('/my-todo-list/archived/' + itemId)
                .then(resp => {
                    // console.log(resp)
                    $_toastAlert('warning', resp.data.message)
                })
            this.fetchItems();
        }
    },
    created() {
        this.fetchItems();
    }
}
</script>
