<template>
    <div :class="alertClass" role="alert">
        <h2>{{ title }}</h2>
        <button class="btn" @click="close">
            <i class="fa-sharp fa-regular fa-circle-xmark fa-2x"></i>
        </button>
    </div>
</template>

<script>
    export default {
        name: 'Popup',
        props: {
            title: String,
            onClose: Function,
            autoClose: Number,
            type: {
                type: String,
                default: 'success'
            }
        },
        methods: {
            close() {
                this.onClose()
            }
        },
        mounted() {
            if (this.autoClose) {
                setTimeout(() => {
                    this.close()
                }, this.autoClose)
            }
        },
        computed: {
            alertClass() {
                return `alert alert-${this.type}`
            }
        }
    }
</script>

<style scoped>
    h2{
        margin: 0;
        padding: 0;
        font-size: 1.5rem;
        font-weight: 400;
        text-align: center;
        width: 100%;
    }
    .alert {
        display:flex;
        flex-direction: row;
        align-items: center;
        position: fixed;
        top: 100px;
        text-align: center;
        width: 50%;
        left: 25%;
    }
</style>