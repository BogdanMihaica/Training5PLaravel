<script>
export default {
    props: {
        isCartPage: {
            type: Boolean,
            default: false,
        },
    },
}
</script>

<template>
    <button :class="{
        'bg-violet-700 hover:bg-violet-600': !isCartPage,
        'bg-red-700 hover:bg-red-600': isCartPage
    }" class="w-60 h-10 rounded-lg text-xl cursor-pointer transition-all duration-300"
        @click.prevent="$emit('action')">

        <span v-if="isCartPage">{{ $t('removeFromCart') }}</span>
        <span v-else>{{ $t('addToCart') }}</span>
        <i :class="{
            'fas fa-plus': !isCartPage,
            'fas fa-x': isCartPage,
            }" 
            class="ml-2 text-lg"
        ></i>

    </button>
</template>