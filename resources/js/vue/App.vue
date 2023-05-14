<template>
    <div class="bg-white p-3 max-w-md mx-auto">
        <div class="text-center">
            <h1 class="text-3xl font-bold">My ToDo List</h1>

            <div class="mt-8">
                <button class="border-2 border-red-500 p-2 text-red-500">Archived Tasks</button>
                <button class="border-2 border-indigo-500 p-2 text-indigo-500 ml-4">Completed Tasks</button>
            </div>

            <item-form></item-form>
        </div>

        <div class="mt-8">
            <ul>
                <item-list :items="items"></item-list>
            </ul>
        </div>
    </div>
</template>

<script>
import ItemList from "@/vue/Item/ItemList.vue";
import ItemForm from "@/vue/Item/ItemForm.vue";
import axios from "axios";

export default {
    components: {ItemForm, ItemList},
    data: function () {
        return {
            items: []
        }
    },
    methods: {
        fetchItems() {
            axios.get('/my-todo-list/items').then(resp => {
                this.items = resp.data.response.data
                console.log(this.items)
            }).catch(xhr => {
                console.log(xhr)
            });
        }
    },
    created() {
        this.fetchItems();
    }
}
</script>
