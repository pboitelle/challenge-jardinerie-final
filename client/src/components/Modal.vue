<script setup>
defineProps({
    showModal: {
        type: Boolean,
        required: true
    },
    title: {
        type: String,
        required: true
    },
    close: {
        type: Function,
        required: true
    }
})
</script>

<template>

<div class="modal" tabindex="-1" :class="{ show: showModal }">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ title }}</h5>
                <button type="button" class="btn-reduire" data-bs-dismiss="modal" aria-label="Close" @click="close">-</button>
            </div>
            <div class="modal-body">
                <slot></slot>
            </div>
        </div>
    </div>
</div>

</template>

<style scoped>
.modal {
    display: none;
    position: fixed;
    top: auto;
    left: auto;
    bottom: 80px;
    right: 20px;
    width: 400px;
    height: 400px;
    overflow: hidden;
    outline: 0;
    border-radius: 10px;
    border: 1px solid #000;
}

.modal .modal-dialog {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
    margin: 0;
}

.modal .modal-content {
    height: 100%;
    border: 0;
    border-radius: 0;
    background-color: #fdfdfd;
}

.modal .modal-header {
    background-color: #212529;
}

.modal .modal-header .btn-reduire {
    color: #000;
    background-color: #fff;
    border-color: #fff;
    border-radius: 5px;
}
.modal .modal-header .btn-reduire:hover {
    color: #fff;
    background-color: #212529;
    border-color: #000;
}


.modal .modal-header .modal-title {
    color: #fff;
}

.modal .modal-body {
    height: calc(100% - 100px);
    overflow-y: auto;
}

.show {
    display: block;
}
</style>