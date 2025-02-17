<script>
export default {
    props: ['error']
}
</script>

<template>
    <p class="text-red-500">{{ error[0] }}</p>
</template>