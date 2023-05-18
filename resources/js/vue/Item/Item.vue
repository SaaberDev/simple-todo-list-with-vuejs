<template>
    <li class="p-2 rounded-lg">
        <div class="flex align-left flex-row justify-between self-center items-center">
            <div class="flex w-3/4">
                <div class="p-2 pl-0">
                    <input type="checkbox"
                           class="h-6 w-6"
                           name="status"
                           :value="1"
                           :checked="this.itemData.isCompleted"
                           v-model="this.itemData.isCompleted"
                           @change="this.$emit('mark-as-done', this.itemData)"
                    />
                </div>
                <div class="p-2">
                    <p class="text-m dark:text-gray-400"
                       :class="[this.itemData.isCompleted ? 'line-through text-gray-400' : '']"
                       v-text="`${this.item.title}`"
                    >
                    </p>
                </div>
            </div>
            <div>
                <span class="text-sm font-medium mr-2 px-2.5 py-0.5 rounded"
                      v-text="this.itemData.isCompleted ? 'Done' : 'Ongoing'"
                      :class="[(this.itemData.isCompleted ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300')]"
                ></span>
            </div>
            <div class="flex justify-between" style="width: 15%; height: fit-content;">
                <edit-btn :itemId="this.item.id"></edit-btn>
                <delete-btn :itemId="this.item.id"></delete-btn>
            </div>
        </div>
        <hr class="mt-2"/>
    </li>
</template>

<script>
import DeleteBtn from "./DeleteBtn.vue";
import ArchiveBtn from "@/Item/DeleteBtn.vue";
import EditBtn from "@/Item/EditBtn.vue";

export default {
    components: {EditBtn, ArchiveBtn, DeleteBtn},
    props: ['item'],
    data: function () {
        return {
            itemData: {
                id: this.item.id,
                isCompleted: this.item.status === 1
            }
        }
    },
}
</script>
