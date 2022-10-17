<template>
    <div class="container">
        <div class="row row-bg">
            <div class="col-md-12">
                <div class="m-3">
                    <h1><i class="fa-solid fa-comment"></i> ChatApp</h1>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 mt-2 background">
                <div class="card p-3">
                    <div class="card-body">
                        <div class="message-area" id="messageArea">
                            <div class="message-left">
                                <h6>Hello, Babe! How you doing?</h6>
                                <span class="message-time"
                                    ><i class="fas fa-check"></i> 2 min
                                    ago</span
                                >
                            </div>
                            <div
                                class="message-left"
                                v-for="ch in chat.messages"
                            >
                                <h6>{{ ch }}</h6>
                                <span class="message-time"
                                    ><i class="fas fa-check"></i> 1 min
                                    ago</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div
                    class="col-md-6 offset-md-3 d-flex text-center message-box"
                >
                    <form @submit.prevent="sendMessage" method="post">
                        <input
                            type="text"
                            class="form-control"
                            @keyup="Typing()"
                            v-model="message"
                            id="messageData"
                            placeholder="Message Here..."
                        />
                        <button class="btn-vue" type="submit">
                            <i class="fas fa-paper-plane font"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import pusher from 'pusher-js';
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return{
                message: '',
                typing: '',
                // chat: {
                //     messages: []
                // }
            }
        },
        methods: {
            sendMessage(){
                // this.chat.message.push(this.message);
                axios.post('/send/message',{message: this.message}).then(function (response) {
                    console.log(response.data);
                }).catch(function (error) {
                    console.log(error);
                });
                this.chatBroadCast();
                // this.message = '';
            },
            chatBroadCast(){
                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;
                var pusher = new Pusher('6b5c625fde26fa276545', {
                cluster: 'ap2'
                });
                var channel = pusher.subscribe('my-channel');
                    channel.bind('my-event', function(data) {
                    console.log(data['message']);
                    console.log(data['user']);
                    this.chat.messages.push(data['message']);
                    // if(data.message){
                    //     this.message = data;
                    //
                    //     this.message = '';
                    // }
                });
            },
            Typing(){
                this.typing = "user typing.....";
            },
        },
        // created(){
        //     this.chatBroadCast();
        // },

    }
</script>

<style scoped>
.container {
    background-color: rgb(242, 242, 242);
}
.background {
    background-color: rgb(242, 242, 242);
    height: 75vh;
    overflow-y: scroll;
}
.row-bg {
    background-color: #41b883;
    color: #fff;
}
.card {
    border: #fff;
    background-color: rgb(242, 242, 242);
}
.card-header {
    border: none;
    background-color: #41b883;
    border-radius: 5px;
    color: #fff;
}
.message-left {
    background-color: #34495e;
    color: #fff;
    padding: 7px;
    border-radius: 9px;
    margin-bottom: 8px;
    /* width: 80%; */
}
.btn-vue {
    color: #fff;
    border: #41b883;
    background-color: #41b883;
    padding: 5px;
    border-radius: 5px;
}
.message-right {
    background-color: #fff;
    color: #34495e;
    padding: 7px;
    border-radius: 5px;
    margin-bottom: 8px;
    /* width: 80%; */
}
.message-time {
    font-size: 11px;
}
.form-control {
    box-shadow: none;
    border: none;
}
.font {
    font-size: 16px;
    margin: 5px;
}
</style>
