<template>
    <nav class="nav">
        <router-link :to="{ name: 'home' }" class="nav-brandlogo">
            <img src="../assets/images/logo/logo_desk.svg" alt="logo" />
        </router-link>
        <div class="nav-items">
            <router-link :to="{ name: 'chatting_room' }">
                <img src="../assets/images/icon/chat.svg" alt="chat icon" />
                <h3>聊天大廳</h3>
            </router-link>
            <router-link :to="{ name: 'playground' }">
                <img src="../assets/images/icon/game.svg" alt="game icon" />
                <h3>遊樂場</h3>
            </router-link>
            <router-link :to="{ name: 'activity' }">
                <img src="../assets/images/icon/activity.svg" alt="activity icon" />
                <h3>主題活動</h3>
            </router-link>
            <router-link :to="{ name: 'about-us' }">
                <img src="../assets/images/icon/about-us.svg" alt="activity icon" />
                <h3>關於我們</h3>
            </router-link>
            <router-link :to="{ name: 'service' }">
                <img src="../assets/images/icon/qa.svg" alt="activity icon" />
                <h3>我有問題</h3>
            </router-link>
        </div>
        <div class="statement">
            <p>
                ©本網站為緯育TibaMe第87期前端工程師專業技術養成班學員作品,僅供學習、展示之用途。
            </p>
        </div>
    </nav>
</template>