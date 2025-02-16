<script>
export default {
    props: ['error']
}
</script>

<template>
    <p v-if="error" class="text-red-500">{{ error[0] }}</p>
</template>