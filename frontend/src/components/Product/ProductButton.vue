<script>
import CircleLoader from '../Loaders/CircleLoader.vue';

export default {
    components: {CircleLoader},
    
    props: {
        isCartPage: {
            type: Boolean,
            default: false,
        },
        disabled: Boolean
    },
}
</script>

<template>
    <button 
        :class="{
            'bg-violet-700 hover:bg-violet-600': !isCartPage,
            'bg-red-700 hover:bg-red-600': isCartPage,
            'cursor-not-allowed' : disabled,
            'cursor-pointer' : !disabled
        }"
        class="w-60 h-10 rounded-lg text-xl transition-all duration-300"
        @click.prevent="$emit('action')"
        :disabled="disabled"
    >
        <CircleLoader v-if="disabled" />
        <div v-else>
            <span v-if="isCartPage">{{ $t('removeFromCart') }}</span>
            <span v-else>{{ $t('addToCart') }}</span>
            <i 
                :class="{
                    'fas fa-plus': !isCartPage,
                    'fas fa-x': isCartPage,
                }" 
                class="ml-2 text-lg"
            ></i>
        </div>
    </button>
</template>