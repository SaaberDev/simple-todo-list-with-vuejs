<template>
    <div class="mt-4 flex">
        <input class="w-80 border-b-2 border-gray-500 text-black"
               type="text"
               placeholder="Enter your task here"
               v-model="item.title"
        />

        <button class="ml-2 border-2 border-green-500 p-2 rounded-lg flex"
                :disabled="!item.title"
                :class="[(item.title ? 'text-green-500' : 'disabled:opacity-25'), (!buttons.addBtn ? 'hidden' : '' ) ]"
                @click="this.$emit('create-new-item', this.item)"
        >
            <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z"/>
                <circle cx="12" cy="12" r="9"/>
                <line x1="9" y1="12" x2="15" y2="12"/>
                <line x1="12" y1="9" x2="12" y2="15"/>
            </svg>

            <span>Add</span>
        </button>

        <button class="ml-2 border-2 border-green-500 p-2 rounded-lg flex"
                :disabled="!item.title"
                :class="[(item.title ? 'text-green-500' : 'disabled:opacity-25'), (!buttons.updateBtn ? 'hidden' : '' ) ]"
                @click="this.$bus.$emit('update-item', {item: this.item})"
        >
            <svg class="h-6 w-6" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z"/>
                <circle cx="12" cy="12" r="9"/>
                <line x1="9" y1="12" x2="15" y2="12"/>
                <line x1="12" y1="9" x2="12" y2="15"/>
            </svg>

            <span>Update</span>
        </button>

        <button class="ml-2 border-2 text-red-600 border-red-500 p-2 rounded-lg flex"
                :disabled="!item.title"
                :class="[(!buttons.cancelBtn ? 'hidden' : '' )]"
                @click="this.$bus.$emit('cancel-update', {item: this.item})"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>

            <span>Cancel</span>
        </button>
    </div>

    <div class="text-left text-red-600"
         :class="[(item.validationMessage ? '' : 'hidden'), (item.title === ''  ? item.validationMessage = false : '')]"
         v-text="item.errors.message"
    >
    </div>
</template>

<script>
import axios from "axios";
import buttons from "@/buttons.js";

export default {
    computed: {
        buttons() {
            return buttons
        }
    },
    data: function () {
        return {
            item: {
                validationMessage: false,
                errors: [],
                title: '',
                id: ''
            },
        }
    },
    created() {
        if (this.item.title.empty) {
            this.item.validationMessage = false
        }
        this.$bus.$on('edit-item', async (itemId) => {
            await axios.get('/my-todo-list/edit/' + itemId)
                .then(resp => {
                    // console.log(resp.data.response.title)
                    this.item.title = resp.data.response.title
                    this.item.id = resp.data.response.id
                    buttons.addBtn = false;
                    buttons.updateBtn = true;
                    buttons.cancelBtn = true;
                }).catch(xhr => {
                    // console.log(xhr)
                });
        });
    }
}
</script>
