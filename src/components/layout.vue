<template>
    <main class="main-block">
        <div class="main">
            <section class="section-left">
                <navbar></navbar>
            </section>
            <section class="section-right">
                <!-- <h1>this is right</h1>
                <div class="btn btn-dark">開始</div>
                <div class="btn btn-light">取消</div> -->
                <div class="user-info"></div>
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