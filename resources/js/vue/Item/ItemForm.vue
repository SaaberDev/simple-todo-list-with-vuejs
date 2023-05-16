<template>
    <div class="mt-4 flex">
        <input class="w-80 border-b-2 border-gray-500 text-black"
               type="text"
               placeholder="Enter your task here"
               v-model="item.title"
        />

        <button class="ml-2 border-2 border-green-500 p-2 <!--hover:text-white hover:bg-green-500--> rounded-lg flex"
                :disabled="!item.title"
                :class="[item.title ? 'text-green-500' : 'disabled:opacity-25' ]"
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
    </div>

    <div class="text-left text-red-600"
         :class="[(validationMessage ? '' : 'hidden'), (this.item.title == '' && validationMessage == false  ? validationMessage = false : '')]"
         v-text="this.errors.message"
    >
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            validationMessage: false,
            errors: {},
            item: {
                title: ''
            }
        }
    }
}
</script>
