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
                       @change="this.$emit('mark-as-done', this.itemData)"
                />
            </div>
            <div class="p-2">
                <p class="text-lg dark:text-gray-400"
                   :class="[this.itemData.isCompleted ? 'line-through text-gray-400' : '']"
                   v-text="`${this.item.title}`"
                >
                </p>
            </div>
            <archive-btn :itemId="this.item.id"
            ></archive-btn>
        </div>
        <hr class="mt-2"/>
    </li>
</template>

<script>
import DeleteBtn from "./ArchiveBtn.vue";
import ArchiveBtn from "@/Item/ArchiveBtn.vue";

export default {
    components: {ArchiveBtn, DeleteBtn},
    props: ['item'],
    data: function () {
        return {
            itemData: {
                id: this.item.id,
                isCompleted: this.item.completed_at != null
            }
        }
    }
}
</script>
