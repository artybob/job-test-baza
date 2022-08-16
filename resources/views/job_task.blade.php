<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    {{--vuetify--}}
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    {{--vuetify--}}
</head>
<body class="antialiased">
<div id="app">
    <v-app>
        <v-container fill-height fluid>

            <v-container>
                <v-row align="center"
                       justify="center">
                    <v-col cols="6">
                        <v-card style="padding: 20px">
                            <div class="card-header mb-4">
                                <h3>Directory form 4:20</h3>
                            </div>
                            <div class="card-body">
                                <v-row>
                                    <v-col
                                        md="5"
                                    >
                                        <v-text-field
                                            outlined
                                            v-model="folderFrom"
                                            label="Folder from"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        md="5"
                                    >
                                        <v-text-field
                                            outlined
                                            v-model="folderTo"
                                            label="Folder to"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        md="2"
                                    >
                                        <v-btn
                                            depressed
                                            outlined
                                            block
                                            text
                                            style="height: 56px"
                                            id="fileButton"
                                            @click="changeFolder()">
                                            Change
                                        </v-btn>
                                    </v-col>
                                </v-row>

                            </div>
                        </v-card>
                    </v-col>
                </v-row>
                <v-row align="center"
                       justify="center">
                    <v-col cols="6">
                        <v-card style="padding: 20px">
                            <div class="card-header mb-4">
                                <h3>File form</h3>
                            </div>
                            <div class="card-body">
                                <v-row>
                                    <v-col
                                        md="8"
                                    >
                                        <v-file-input
                                            v-model="chosenFile"
                                            outlined
                                            required
                                            accept=".txt"
                                            label="File input"
                                        ></v-file-input>
                                    </v-col>
                                    <v-col
                                        md="2"
                                    >
                                        <v-text-field
                                            v-model="symbol"
                                            label="Symbol"
                                            outlined
                                            required
                                        ></v-text-field>
                                    </v-col>
                                    <v-col
                                        md="2"
                                    >
                                        <v-btn
                                            depressed
                                            outlined
                                            block
                                            text
                                            style="height: 56px"
                                            id="fileButton"
                                            @click="processFile()">
                                            Go
                                        </v-btn>
                                    </v-col>
                                </v-row>


                                <v-row>
                                    <div v-if="pieces" class="ml-4 mb-4 mt-4" style="overflow: overlay;">
                                    <span class="mb-4">
                                        <h3>Result:</h3>
                                    </span>
                                        <ul v-for="p in pieces">
                                            <li>
                                                @{{p}} - (@{{p.length}})
                                            </li>
                                        </ul>
                                    </div>
                                </v-row>

                            </div>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>

            <v-snackbar
                timeout="4000"
                success
                :color="alertType"
                v-model="alert"
            >
                @{{ resText }}
            </v-snackbar>
        </v-container>

    </v-app>

    {{--формы для поиска на странице--}}
    <form action="" id="frm1"></form>
    <form action="" id="frm2"></form>
    <button id="btn1" type="button"></button>
</div>
</body>

<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script>
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: {
            chosenFile: null,
            folderFrom: "{{$file_urls['folder_from']}}",
            folderTo: "{{$file_urls['folder_to']}}",
            alert: false,
            resText: '',
            symbol: '@',
            pieces: null,
            alertType: 'success',
        },
        methods: {
            changeFolder() {
                this.initState()

                let formData = new FormData()
                formData.append("folder_from", this.folderFrom)
                formData.append("folder_to", this.folderTo)

                axios.post('http://127.0.0.1:8000/change_folders', formData).catch((err) => {
                    this.alertType = 'error'
                    this.resText = 'Server error'
                    if (err.response.data.message) {
                        this.resText = err.response.data.message
                    }
                }).then((res) => {
                    this.resText = res.data.msg
                });

                this.alert = true
            },
            processFile() {
                this.initState()
                //загрузка файла
                if (!this.chosenFile) {
                    this.resText = 'No File Chosen'
                    this.alertType = 'error'
                    this.alert = true
                    return
                }

                let formData = new FormData()
                formData.append("chosenFile", this.chosenFile)
                formData.append("symbol", this.symbol)

                axios.post('http://127.0.0.1:8000/process_file', formData).catch((err) => {
                    this.alertType = 'error'
                    this.resText = 'Server error'
                    if (err.response.data.message) {
                        this.resText = err.response.data.message
                    }
                }).then((res) => {
                    this.pieces = res.data.pieces
                });

                this.alert = true
            },
            initState() {
                this.pieces = null
                this.resText = ''
                this.alert = false
                this.alertType = 'success'
                this.resText = 'OK'
            }
        }
    })
</script>
<script>
    window.onload = function () {
        //поиск form
        let list = document.getElementsByTagName("form");
        for (let item of list) {
            console.log(item.id);
        }
        //поиск button с типом submit (отправка данных)
        list = document.getElementsByTagName("button");
        for (let item of list) {
            if (item.type == 'submit') {
                console.log(item.id);
            }
        }
    };

</script>
</html>
