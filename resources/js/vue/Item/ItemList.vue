<template>
    <item v-for="(item, index) in items"
          :key="index"
          :item="item"
    ></item>
</template>

<script>
import Item from "@/vue/Item/Item.vue";

export default {
    components: {Item},
    props: ['items']
}
</script>
