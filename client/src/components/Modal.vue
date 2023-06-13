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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ title }}</h5>
                <button class="btn-reduire" data-bs-dismiss="modal" aria-label="Close" @click="close"><i class="fa-regular fa-rectangle-xmark"></i></button>
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
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    display: none;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -50px);
    max-width: 800px;
}

.modal.show .modal-dialog {
    transform: translate(0, 0);
    max-width: 800px;
}

.modal .modal-header {
    background-color: #212529;
}

.modal .modal-header .btn-reduire {
    color: #000;
    background-color: #fff;
    border-color: #fff;
    border-radius: 5px;
    width: 20%;
    height: 30px;
    margin: 0;
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
    width: 100%;
    height: calc(100% - 100px);
    overflow-y: auto;
    color: #000;
}

.show {
    display: block;
}

@media screen and (max-width: 768px) {
    
}
</style>