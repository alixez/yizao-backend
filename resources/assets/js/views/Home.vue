<template>
    <div class="content has-text-centered">
        <p>
            <img src="~images/logo.svg" alt="description" width="200">
        </p>

        <h1 class="is-title is-bold">首页</h1>

        <p>Supports Vue 2.0 and bulma 0.3</p>
    </div>
</template>

<script>
    export default {
        data() {
            return this.$store.state.pkg
        }
    }
</script>

<style lang="scss" scoped rel="stylesheet/scss">
    .is-title {
        text-transform: capitalize;
    }
</style>