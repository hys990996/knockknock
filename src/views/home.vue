<template>
    <layout>
        <template #section-right-content>
            <div class="home">
                <div class="home-post">
                    <input type="text">
                </div>
                <div class="home-info"></div>
            </div>
        </template>
    </layout>
</template>
<script>
//import 這頁需要的元件
import layout from '@/components/layout.vue'

export default {
    components: {
        layout
    }
}
</script>