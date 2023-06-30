<template>
    <transition name="modal-fade">
        <div class="modal-box">
            <div class="wrapper-modal-layout">
                <div class="modal-layout__container md">
                    <div class="modal-layout">
                        <header class="modal-header" id="modalTitle">
                            <slot name="header"> User Following! </slot>
                            <button
                                type="button"
                                class="btn-close"
                                @click="close"
                                aria-label="Close modal"
                            >
                                &times;
                            </button>
                        </header>

                        <section class="modal-body" id="modalDescription">
                            <slot name="body"></slot>
                        </section>

                        <footer class="modal-footer">
                            <slot name="footer"></slot>
                        </footer>
                    </div>
                </div>
                <div id="modal-backdrop" @click="close"></div>
            </div>
        </div>
    </transition>
</template>
<script>
export default {
    name: "Modal",
    methods: {
        close() {
            this.$emit("close");
        },
    },
};
</script>
<style scoped>
#modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: #000;
    opacity: 0.2;
    z-index: 998;
}
.modal-layout {
    width: 500px;
    height: auto;
}

.modal-layout__container{
  transition: all ease-in-out .8s;
    position: fixed;
    top: 200px;
    left: 0;
    /* height: 100%; */
    /* width: 100%; */
    transform: translate(calc(50vw - 50%));
    max-height: 70vh;
    display: flex;
    flex-flow: column nowrap;
    justify-content: center; /* aligns on vertical for column */
    align-items: center; /* aligns on horizontal for column */
    border: 2px dashed red;
    box-sizing: border-box;
    z-index: 999;
    border-radius: 5px;
}

.wrapper-modal-layout {
  
}
.modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-layout {
    background: #ffffff;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
}

.modal-header,
.modal-footer {
    padding: 15px;
    display: flex;
}

.modal-header {
    position: relative;
    border-bottom: 1px solid #eeeeee;
    color: #4aae9b;
    justify-content: space-between;
}

.modal-footer {
    border-top: 1px solid #eeeeee;
    flex-direction: column;
}

.modal-body {
    position: relative;
    padding: 20px 10px;
}

.btn-close {
    position: absolute;
    top: 0;
    right: 0;
    border: none;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    color: #4aae9b;
    background: transparent;
}

.btn-green {
    color: white;
    background: #4aae9b;
    border: 1px solid #4aae9b;
    border-radius: 2px;
}

.modal-fade-enter,
.modal-fade-leave-to {
    opacity: 0;
}

.modal-fade-enter-active,
.modal-fade-leave-active {
    transition: opacity 0.5s ease;
}
</style>
