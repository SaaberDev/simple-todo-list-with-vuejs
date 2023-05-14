<template>
    <li class="p-2 rounded-lg">
        <div class="flex align-middle flex-row justify-between">
            <div class="p-2">
                <input type="checkbox"
                       class="h-6 w-6"
                       name="completed_at"
                       :value="1"
                       :checked="this.isCompleted"
                       v-model="this.isCompleted"
                       @change="completed"
                />
            </div>
            <div class="p-2">
                <p class="text-lg dark:text-gray-400"
                   :class="[this.isCompleted ? 'line-through text-gray-400' : '']"
                >
                    {{ this.item.title }}
                </p>
            </div>
            <delete-btn></delete-btn>
        </div>
        <hr class="mt-2"/>
    </li>
</template>

<script>
import axios from "axios";
import DeleteBtn from "@/vue/Item/DeleteBtn.vue";

export default {
    components: {DeleteBtn},
    props: ['item'],
    data: function () {
        return {
            isCompleted: this.item.completed_at != null
        }
    },
    methods: {
        completed() {
            axios.patch('/my-todo-list/mark-as-done/' + this.item.id, {
                _token: csrfToken,
                is_completed: this.isCompleted
            }).catch(xhr => {
                // this.errors = xhr.response.data
                // console.log(this.errors)
            });
        }
    }
}
</script>
