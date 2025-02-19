<script>
export default {
    props: {
        paginationInfo: Object,
    },

    methods: {
        /**
         * Handles the "previous" button click
         */
        handlePrevious() {
            let newPage = this.paginationInfo.current_page > 1 ? 
                            this.paginationInfo.current_page - 1 : 
                            this.paginationInfo.current_page;
                            
            this.$emit('pageChange', newPage);
        },

        /**
         * Handles the "next" button click
         */
        handleNext() {
            let newPage = this.paginationInfo.current_page < this.paginationInfo.last_page ? 
                            this.paginationInfo.current_page + 1 : 
                            this.paginationInfo.current_page;

            this.$emit('pageChange', newPage);
        }
    }
}
</script>

<template>
    <div class="flex gap-50 w-full justify-center my-8">
        <button 
            class="text-white rounded-lg min-w-20 px-4 py-2 bg-violet-800 transition-all 
                    duration-500 flex justify-center items-center text-lg hover:bg-violet-600" 
            @click.prevent="handlePrevious()"
        >
            {{ $t('previous') }}
        </button>
        <button 
            class="text-white rounded-lg min-w-20 px-4 py-2 bg-violet-800 transition-all 
                    duration-500 flex justify-center items-center text-lg hover:bg-violet-600" 
            @click.prevent="handleNext()"
        >
            {{ $t('next') }}
        </button>
    </div>
</template>