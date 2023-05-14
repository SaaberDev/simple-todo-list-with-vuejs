<template>
    <li class="p-2 rounded-lg">
        <div class="flex align-middle flex-row justify-between">
            <div class="p-2">
                <input type="checkbox"
                       class="h-6 w-6"
                       :checked="this.isCompleted"
                       value="true"
                />
            </div>
            <div class="p-2">
                <p class="text-lg text-gray-400"
                   :class="[this.isCompleted ? 'line-through' : '']"
                >
                    {{ this.item.title }}
                </p>
            </div>
            <archive-btn></archive-btn>
        </div>
        <hr class="mt-2"/>
    </li>
</template>

<script>
import ArchiveBtn from "@/vue/Item/ArchiveBtn.vue";

export default {
    components: {ArchiveBtn},
    props: ['item'],
    data: function () {
        return {
            isCompleted: this.item.completed_at != null
        }
    }
}
</script>
