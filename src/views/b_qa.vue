<template>
    <Backlayout @toggleBlur="updateBlurStatus">
        <template #section-right-content>
            <div class="b_qa">
                <div class="qa-section" :class="{ 'blurred': isBlurred }">
                    <h1>常見問題管理</h1>
                    <div class="qa">
                        <div class="qa-img"></div>
                        <p>{{ getUserName }}</p>
                        <img @click="b_logOut" class="b_logout_img" src="../assets/images/b_login/log-out.png" alt="">
                    </div>

                </div>


                <div class="table-section" :class="{ 'blurred': isBlurred }">
                    <div class="search-section">
                        <div class="search-section-left">
                            <select name="qa" id="pet-select" placeholder="問題類別" v-model="b_qa_category_id">
                                <option v-for="item in b_qa_category" :key="item.QUESTION_CATEGORY_ID"
                                    :value="item.QUESTION_CATEGORY_ID">{{
                                        item.QUESTION_CATEGORY_NAME
                                    }}</option>

                            </select>
                        </div>
                        <div class="search-section-right">
                            <div class="form-floating mb-3">
                                <input type="search" class="form-control" id="floatingInput" placeholder="常見提問搜尋"
                                    v-model="qaQuery" @input="filterQuestions">
                                <label for="floatingInput">以常見提問搜尋</label>
                                <span>搜尋</span>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered ">
                        <thead>
                            <tr class="table-warning">

                                <th scope="col">問題編號</th>
                                <th scope="col">常見提問</th>
                                <th scope="col">回覆內容</th>

                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(i, index) in  qaDisplayItems" :key="i.QUESTION_ID">

                                <td>{{ i.QUESTION_ID }}</td>
                                <td v-if="i.QUESTION_CATEGORY_ID === b_qa_category_id || !b_qa_category_id">
                                    {{
                                        i.QUESTION_TITLE
                                    }}</td>
                                <td>{{ i.QUESTION_CONTENT }}</td>
                                <td><button class="btn btn btn-warning" @click="show(index)">編輯</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="Pagination" :class="{ 'blurred': isBlurred }">
                    <ul>
                        <li v-for="page in pageCount" :key="page">
                            <button type="button" @click="changePage(page)">{{ page }}</button>
                        </li>
                    </ul>
                </div>
                <div class="editQA" id="editQA" v-if="open">
                    <!-- 外層 -->
                    <div class="dialog" v-for="(i, index) in  qaDisplayItems" :key="i.QUESTION_ID
                        ">
                        <!-- 內容 -->
                        <div class="editTitle" v-if="selectedIndex == index">
                            <span>常見問題管理</span>
                        </div>
                        <div class="editContent" v-if="selectedIndex == index">
                            <div class="editAll_left">
                                <span>問題編號</span>
                                <p>{{ i.QUESTION_ID
                                }}</p>
                                <span>常見問題標題</span>
                                <input type="text" v-model="update_QUESTION_TITLE">
                                <span>回答內容</span>
                                <input type="text" v-model="update_QUESTION_CONTENT">
                            </div>


                        </div>

                        <div class="edit_btn" v-if="selectedIndex == index">
                            <button type="button" class="mil-link" @click="close">關閉</button>
                            <button type="button" class="mil-link" @click="  b_qa_update(index)">儲存</button>
                        </div>
                    </div>
                </div>
            </div>

        </template>
    </Backlayout>
</template>
<script>
//import 這頁需要的元件
import Backlayout from "../components/backlayout.vue";

export default {
    data() {
        return {
            id: 0,
            open: false,
            isBlurred: false,
            selectedIndex: null,
            qaQuery: '',
            // 過濾資料
            filteredQuestions: [],
            // 問題分類區域
            filteredQa: [],
            b_qa_category: [],
            b_qa_category_id: 1,
            qa: [],
            // 當前頁面
            currentPage: 1,
            // 每頁顯示的數量
            itemPerPage: 3,
            // 修改問題資料
            update_QUESTION_TITLE: '',

            update_QUESTION_CONTENT: '',
        }
    },
    methods: {
        // 收尋功能
        filterQuestions() {
            const query = this.qaQuery.toLowerCase();
            this.filteredQuestions = this.qa.filter(item =>
                item.QUESTION_TITLE.toLowerCase().includes(query)
            );
        },
        // 切換頁面
        changePage(page) {
            this.currentPage = page
        },
        show(index) {
            this.$root.$emit('toggleBlur', !this.open);
            this.open = !this.open;
            this.isBlurred = !this.isBlurred;
            this.selectedIndex = index;

            // this.$emit('toggle-blur',this.open);
            // console.log(this.$root.$emit('toggleBlur',this.open))
        },
        close() {
            this.open = false;
            this.isBlurred = false;
        },
        updateBlurStatus(status) {
            this.isBlurred = status;
        },
        // 管理員登出
        deleteCookie(name) {
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC;';
            location.reload()
        },
        // 管理員登出
        b_logOut() {
            fetch("api/b_logout.php",
            )
                .then((res) => {
                    return res.json()
                })
                .then((data) => {
                    if (window.confirm('確定登出嗎?')) {
                        if (data.message == '登出成功') {
                            this.deleteCookie("bUserName")
                            this.deleteCookie("bUserId")
                            this.$router.push('/backend')
                            console.log(data)
                        }

                    }


                })
        },
        // 更新提問資料
        b_qa_update(index) {
            const selectQaTitle = this.update_QUESTION_TITLE;
            const selectQaContent = this.update_QUESTION_CONTENT
            fetch('api/b_qa_update.php', {
                header: { 'Content-Type': 'application/json' },
                mode: 'cors',
                method: 'POST',
                body: JSON.stringify({
                    QUESTION_ID: this.qaDisplayItems[index].QUESTION_ID,
                    QUESTION_TITLE: selectQaTitle,
                    QUESTION_CONTENT: selectQaContent

                })
            })
                .then((res) => {
                    return res.json()
                })
                .then((data) => {
                    console.log(data);
                })
            this.close();
            location.reload();
        }
    },
    computed: {

        fliterQa() {
            const query = this.qaQuery.toLowerCase();
            return this.qa.filter((i) => {
                return i.QUESTION_TITLE.toLowerCase().includes(query)
            })
        },
        getUserName() {
            const cookie = document.cookie;
            const cookiesArray = cookie.split(';');
            let username = '';
            cookiesArray.forEach((cookieItem) => {
                const [name, value] = cookieItem.trim().split('=');
                if (name === 'bUserName') {
                    username = value;
                }
            });
            // 如果找到 'bUserName' 的 cookie，則取出其值
            if (username !== '') {
                console.log(`Username: ${username}`);
                return username; // 返回取得的 username
            } else {
                console.log('找不到 bUserName 的 Cookie');
                return ''; // 或者返回空字符串或其他你認為合適的值
            }
        },
        // 選單搜尋
        filteredQuestions() {
            if (!this.b_qa_category_id) {
                return this.qa
            }
            else {
                return this.qa.filter(question => question.QUESTION_CATEGORY_ID === this.b_qa_category_id)
            }
        },
        // 計算頁面數量
        pageCount() {
            return Math.ceil(this.filteredQuestions.length / this.itemPerPage);
        }
        ,
        qaDisplayItems() {
            this.filteredQa = this.fliterQa;
            const startIndex = (this.currentPage - 1) * this.itemPerPage;
            const endPage = startIndex + this.itemPerPage;
            return this.filteredQuestions.slice(startIndex, endPage);

        }

    },
    watch: {
        // 監視 b_qa_category_id 變化，當其改變時重新過濾資料
        b_qa_category_id() {
            if (this.b_qa_category_id) {
                this.filteredQuestions = this.qa.filter(question => question.QUESTION_CATEGORY_ID === this.b_qa_category_id);
            } else {
                this.filteredQuestions = this.qa;
            }
        },
        // 監視 qaQuery 變化，當其改變時重新過濾資料
        qaQuery() {
            const query = this.qaQuery.toLowerCase();
            this.filteredQuestions = this.qa.filter(item => item.QUESTION_TITLE.toLowerCase().includes(query));
        }
    },
    mounted() {
        fetch('api/b_qa_category.php')
            .then((res) => {
                return res.json()
            })
            .then((data) => {
                this.b_qa_category = data;
                this.b_qa_category_id = data.QUESTION_CATEGORY_ID
                console.log(data);
            });
        fetch('api/b_qa.php')
            .then((res) => {
                return res.json()
            })
            .then((data) => {
                this.qa = data;
                this.filteredQuestions = data
                console.log(data)
            })
        console.log(this.b_qa_category_id)
    },
    components: {
        Backlayout
    }
}
</script>