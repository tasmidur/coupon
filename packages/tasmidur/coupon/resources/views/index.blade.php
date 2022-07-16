<html>
<head>
    <title></title>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        #App {
            margin: 20px;
            padding: 20px;
        }

        .div_Master {
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div id="App">
    <h3 style="margin-top: 20px;text-align: center;">Coupon Management</h3>
    <hr>
    <div class="div_Master">
        <form>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="couponType">CouponType</label>
                    <select id="couponType" class="form-control" v-model="couponType" required>
                        <option selected value="Select">Select</option>
                        <option value="FIXED_PRICE">Fixed Price</option>
                        <option value="DISCOUNT_PRICE">Discount Price</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="couponPrice">CouponPrice</label>
                    <input type="number" class="form-control" id="couponPrice" placeholder="CouponPrice"
                           v-model="couponPrice" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="expiredAt">ExpiredAt</label>
                    <input type="datetime-local" class="form-control" id="expiredAt" placeholder="expiredAt"
                           v-model="expiredAt">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-primary" v-on:click="btnSubmit()" style="float: right">
                        @{{btnMode}}
                    </button>
                </div>
            </div>
        </form>
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
        </tr>
        <tr>
            <th scope="row">3</th>
            <td colspan="2">Larry the Bird</td>
            <td>@twitter</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
<script>
    $(() => {
        const app = new Vue({
            el: '#App',
            data: {
                couponType: 'Select',
                couponPrice: 0,
                prefix: '',
                suffix: '',
                expiredAt: '',
                formData: {},
                Editmode: true,
                updatemode: false,
                btnMode: "Submit",
                Validate: 0,
                Id: 1
            },

            methods: {
                btnSubmit: function () {
                    this.formData = {
                        coupon_type: this.couponType,
                        coupon_price: this.couponPrice,
                        prefix: this.prefix,
                        suffix: this.suffix,
                        expired_at: this.expiredAt
                    };
                    if (this.btnMode === "Update") {
                        this.btnMode = "Submit";
                    }
                    axios.post('http://localhost:8001/coupons', this.formData)
                        .then((response) => {
                            this.formData = {};
                            console.log(response);
                        })
                },
                OnEdit: function (d) {
                    let fitdata = (this.fullData).filter(function (val) {
                        return val.Id === d
                    });
                    this.Id = fitdata[0].Id;
                    this.name = fitdata[0].Name;
                    this.emailid = fitdata[0].emailid;
                    this.role = fitdata[0].role;
                    this.btnMode = "Update";
                    this.fullData = (this.fullData).filter(function (val) {
                        return val.Id !== d
                    });
                },

                OnDelete: function (d) {
                    this.fullData = (this.fullData).filter(function (val) {
                        return val.Id !== d
                    });
                }
            }
        });
    })
</script>
</html>
