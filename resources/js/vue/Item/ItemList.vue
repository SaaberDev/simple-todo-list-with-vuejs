<template>
    <item v-for="(item, index) in items"
          :key="index"
          :item="item"
    ></item>
</template>

<script>
import ArchiveBtn from "@/vue/Item/ArchiveBtn.vue";
import Item from "@/vue/Item/Item.vue";
import axios from "axios";

export default {
    components: {Item, ArchiveBtn},
    props: ['items']
}
</script>
