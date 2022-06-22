<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous"> <!-- bootstrap css CDN kütüphanesi dahil ediliyor -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/> <!-- font awesome css CDN Kütüphanesi dahile diliyor. (fa iconları) -->

</head>
<body style="background-image: url('https://hougumlaw.com/wp-content/uploads/2016/05/light-website-backgrounds-light-color-background-images-light-color-background-images-for-website-1024x640.jpg')">
<script src="https://unpkg.com/vue@3"></script> <!-- vue 3 js kütüphanesi dahil ediliyor. -->

<div class="container mt-4" id="app">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4" v-for="type in types" v-bind:key="type.type">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            {{type.label}}
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li v-for="task in tasks.filter(task=>task.type==type.type)"
                                class="list-group-item d-flex justify-content-between">
                                <div>
                                    {{task.title}} - <small style="color: gray">{{moment(task.date,"YYYY-MM-DD").format("DD/MM/YYYY")}}</small> <span class="text-muted">{{task.name}}</span>
                                </div>

                                <div>
                                    <button class="btn btn-warning" @click="editTask(task.id)"> <!-- Görev düzenleme butonu -->
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" @click="deleteTask(task.id)"> <!-- Görevi Siliyoruz -->
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header bg-success">
                        <div class="card-title text-white">
                            {{ this.editid == null ? 'Yeni Görev' : 'Görev Düzenle' }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Başlık</label>
                            <input type="text" id="title" v-model="title" placeholder="Görev Başlığı"
                                   class="form-control">
                        </div>
                        <div class="form-group my-3">
                            <label for="description">Açıklama</label>
                            <textarea name="" v-model="description" placeholder="Görev Açıklaması" id="description"
                                      cols="10" rows="5" class="form-control "></textarea>

                        </div>
                        <div class="form-group my-2">
                            <label for="date">Tarih</label>
                            <input type="date" id="date" v-model="date" class="form-control" placeholder="tarih">
                        </div>
                        <div class="form-group"> <!-- eğer edit modunda değilse bu form grup çalışıyor, süreç sadece editte değiştirilebiliyor -->
                            <label for="date">İsim</label>
                            <select name="" id="" class="form-control" v-model="name">
                                <option :value="nm" v-for="nm in names">{{nm}}</option> <!-- görev tipleri (yeni, tamamlandı vs.) döngü içinde geliyor -->
                            </select>
                        </div>
                        <div class="form-group" v-if="editid!=null"> <!-- eğer edit modunda değilse bu form grup çalışıyor, süreç sadece editte değiştirilebiliyor -->
                            <label for="date">Süreç</label>
                            <select name="" id="" class="form-control" v-model="type">
                                <option :value="type.type" v-for="type in types">{{type.label}}</option> <!-- görev tipleri (yeni, tamamlandı vs.) döngü içinde geliyor -->
                            </select>
                        </div>
                        <div class="text-end mt-2">
                            <button class="btn btn-success mr-2" @click="addTask" v-if="editid==null">Ekle</button> <!-- eğer ekleme modundaysa kaydete tıklandıgında addTask çalışıyor-->
                            <div v-else>
                                <button class="btn btn-success mr-2" @click="updateTask">Kaydet</button><!--kaydete tıklandığında updatetask çalışıyor -->
                                <button class="btn btn-dark" @click="this.resetTasks">
                                    Vazgeç
                                </button> <!-- Vazgeçe tıklandığında resetTask fonksiyonu çalışıyor -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script> <!-- stil işlemleri için bootstrap js ekliyoruz -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> <!-- bildirim için sweet alert kütüphanesini ekliyoruz -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.24.3/vuedraggable.umd.js" integrity="sha512-MPl1xjL9tTTJHmaWWTewqTJcNxl2pecJ0D0dAFHmeQo8of+F9uF7zb2bazCX7m45K3mKRg44L1xJDeFzjmjRtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> <!-- vue kütüphanesini ekliyoruz -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js" ></script> <!-- zaman işlemleri için mooment kütüphanesini ekliyoruz -->

<script>
    const {createApp} = Vue

    createApp({ // vue instance oluşturuluyor
        data() { // program için gerekli variable'lar burada tanımlanıyor.
            return {
                tasks: [
                ],
                editid: null,
                date: '',
                description: '',
                title: '',
                type: null,
                name:null,
                names:[
                  "Ali Arı",
                  "Abdulkadir Deveci",
                  "Mehmet Demir",
                  "Harun Çelik"
                ],
                moment:moment,
                editMode: false,
                types: [{label: 'Yeni Görevler', type: 'new'}, {
                    label: 'Bekleyen Görevler',
                    type: 'waiting'
                }, {label: 'Tamamlanmış Görevler', type: 'done'}]
            }
        },
        methods: { // methodlar burada
            editTask(id) { // burada görev düzenleniyor
                let task = this.tasks.find(task => task.id == id)
                this.editid = task.id
                this.title = task.title
                this.description = task.description
                this.date = task.date
                this.type = task.type
                this.name = task.name
            },
            resetTasks() { //vazgeç butonuna basıldığında edit mode'dan yeni görev oluştur moduna geçiyor
                this.title = '';
                this.editid = null;
                this.date = '';
                this.description = ''
                this.name = ''
            },
            updateTask() { // eğer edit mode'da ise burada görevi güncelliyor
                if (this.editid == null) {
                    return
                }
                let task = this.tasks.find(task => task.id == this.editid)
                task.title = this.title
                task.description = this.description
                task.type = this.type
                task.date = this.date
                task.name = this.name
                swal("Başarılı", "Görev Başarıyla Değiştirildi!", 'success') //swal gördüğümüz yerler bildirim veriyor.
                this.resetTasks()
            },
            deleteTask(id) { // görevi silmeye yarıyor
                this.tasks = this.tasks.filter(task => task.id != id)
                swal("Başarılı", "Görev Başarıyla Silindi!", "success")
            },
            addTask() { // görev ekleniyor
                if (this.title.length < 1) { // başlık değeri boş geçilemez uyarısı

                    swal("Hata", "Lütfen Görev Başlığı Girin", "error")
                    return
                }
                if (this.description.length < 1) { // açıklama değeri boş geçilemez uyarısı

                    swal("Hata", "Lütfen Görev Açıklamasını Girin", "error")
                    return
                }
                if (this.date.length < 1) { // görev tarihi değeri boş geçilemez uyarısı

                    swal("Hata", "Lütfen Görev Tarihini Girin", "error")
                    return
                }
                if (this.name.length < 1) { // görev tarihi değeri boş geçilemez uyarısı

                    swal("Hata", "Lütfen İsmi Seçin", "error")
                    return
                }
                this.tasks.push({ // görev tasks arrayine ekleniyor.
                    id: Math.floor(Math.random() * 10000000),
                    type: 'new',
                    title: this.title,
                    description: this.description,
                    date: this.date,
                    name: this.name,
                })
                this.resetTasks() // görev eklendikten sonra inputtaki değerler boşaltılıyor
                swal("Başarılı", "Görev Başarıyla Eklendi!", "success")
                console.log(this.tasks)
            }
        },
    }).mount('#app') // vue instance'ını app idli elemente mount ediyor.
</script>
</body>
</html>
