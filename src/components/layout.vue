<template>
    <main class="main-block">
        <div class="main">
            <section class="section section-left">
                <navbar></navbar>
                <div class="left-expand">
                    <button>
                        <img src="../assets/images/icon/right-arrow.svg" alt="">
                    </button>
                </div>
            </section>
            <section class="section-right">
                <slot name="section-right-content"></slot>
            </section>
        </div>
    </main>
</template>
<script>
//import 這頁需要的元件
import navbar from '@/components/navBar.vue'

export default {
    components: {
        navbar
    }
}
</script>