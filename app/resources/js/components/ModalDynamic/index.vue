
<template>
    <transition name="modal-fade">
       <div class="modal-box">
        <div class="wrapper-modal-layout">
           <div class="modal-layout__container md">
             <div
               class="modal-layout"
             >
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
        </div>
        <div id="modal-backdrop" @click="close"></div>
       </div>
     </transition>
   </template>
<script>
  export default {
    name: 'Modal',
    methods: {
      close() {
        this.$emit('close');
      },
    },
  };
</script>
<style scoped>
#modal-backdrop{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  background: #000;
  opacity: 0.2;
  z-index: 999;
}
.modal-layout{
  width: 500px;
  height: auto;
}

.wrapper-modal-layout{
    position: fixed;
    top: 20%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 10px;
    transition: all ease-in-out .8s;
    z-index: 9999;
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
    background: #FFFFFF;
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
    color: #4AAE9B;
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
    color: #4AAE9B;
    background: transparent;
  }

  .btn-green {
    color: white;
    background: #4AAE9B;
    border: 1px solid #4AAE9B;
    border-radius: 2px;
  }

  .modal-fade-enter,
  .modal-fade-leave-to {
    opacity: 0;
  }

  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity .5s ease;
  }
</style>