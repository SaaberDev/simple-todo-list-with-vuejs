<template>
    <li class="p-2 rounded-lg">
        <div class="flex align-middle flex-row justify-between">
            <div class="p-2">
                <input type="checkbox"
                       class="h-6 w-6"
                       name="completed_at"
                       :value="1"
                       :checked="this.itemData.isCompleted"
                       v-model="this.itemData.isCompleted"
                       @change="completed"
                />
            </div>
            <div class="p-2">
                <p class="text-lg dark:text-gray-400"
                   :class="[this.itemData.isCompleted ? 'line-through text-gray-400' : '']"
                >
                    {{ this.item.title }}
                </p>
            </div>
            <delete-btn :itemId="this.item.id"
                        v-on:event-to-item="eventToItemList($event)"
            ></delete-btn>
        </div>
        <hr class="mt-2"/>
    </li>
</template>

<script>
import DeleteBtn from "@/vue/Item/DeleteBtn.vue";

export default {
    components: {DeleteBtn},
    props: ['item'],
    data: function () {
        return {
            itemData: {
                id: this.item.id,
                isCompleted: this.item.completed_at != null
            }
        }
    },
    methods: {
        completed() {
            this.$emit('mark-as-done', this.itemData)
        },
        eventToItemList: function (itemId) {
            this.$emit('event-to-item-list', itemId)
        }
    }
}
</script>
