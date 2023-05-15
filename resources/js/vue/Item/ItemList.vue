<template>
    <item v-for="(item) in items"
          :key="item.id"
          :item="item"
          v-on:mark-as-done="markAsDone($event)"
          v-on:event-to-item-list="eventToParent($event)"
    ></item>
</template>

<script>
import axios from "axios";
import Item from "@/vue/Item/Item.vue";

export default {
    components: {Item},
    props: ['items'],
    methods: {
        markAsDone(data) {
            axios.post('/my-todo-list/mark-as-done/' + data.id, {
                _token: csrfToken,
                is_completed: data.isCompleted
            }).then(resp => {
                $_toastAlert('success', resp.data.message)
            });
        },
        eventToParent: function (itemId) {
            this.$emit('archive-item', itemId);
        }
    }
}
</script>
