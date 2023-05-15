<template>
    <button class="flex text-red-500 border-2 border-red-500 p-2 rounded-lg"
            style="height: 50%"
            @click="archive"
    >
        <svg class="h-6 w-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="15" y1="9" x2="9" y2="15"/>
            <line x1="9" y1="9" x2="15" y2="15"/>
        </svg>
        <!--        <span>Archive</span>-->
    </button>
</template>

<script>
import app from '../App.vue'
import axios from "axios";
export default {
    props: ['itemId'],
    methods: {
        archive() {
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$emit('event-to-item', this.itemId)
                    // axios.post('/my-todo-list/archived/' + this.itemId)
                    //     .then(resp => {
                    //         // console.log(resp)
                    //         $_toastAlert('warning', resp.data.message)
                    //     })
                }
            });
        },
    },
}
</script>
