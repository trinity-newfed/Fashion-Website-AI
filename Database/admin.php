<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "TF_Database";

$conn = new mysqli($host, $user, $password, $dbname);
//PRODUCT FETCH
$product = $conn
    ->query("SELECT * FROM products")
    ->fetch_all(MYSQLI_ASSOC);

//USER FETCH
$userdata = $conn
    ->query("SELECT * FROM userdata")
    ->fetch_all(MYSQLI_ASSOC);

//VOUNCHER FETCH
$vouncher = $conn
    ->query("SELECT * FROM vouncher")
    ->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        html{
            user-select: none;
        }
        #head{
            top: 0;
            width: 100vw;
            height: 100svh;
            max-width: 1500px;
            max-height: 900px;
            position: relative;
            margin: auto;
            display: flex;
            align-items: center;
            flex-direction: column;
        }
        #header{
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            height: 12%;
            border: 1px solid black;
        }
        #head-label{
            width: 15%;
            height: 100%;
            background-color: black;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
        }
        .head-section{
            width: 15%;
            height: 25%;
            border: 1px solid black;
            text-align: center;
            cursor: default;
        }
        .head-section:hover{
            background-color: black;
            color: white;
        }

        #header-body{
            width: 100%;
            height: 85%;
            display: flex;
        }
        #list{
            width: 80%;
            height: 100%;
            border: 1px solid black;
            border-right: none;
            border-top: none;
        }
        .list-view{
            width: 100%;
            height: 100%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-template-rows: repeat(10, 300px);
            overflow-x: hidden;
            padding-top: 20px;
            padding-left: 20px;
        }
        #search{
            width: 20%;
            height: 100%;
            border: 1px solid black;
            border-top: none;
            display: flex; 
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .search-div{
            display: grid;
            place-items: center;
            gap: 10px;
        }

        .head-section.show{
            background-color: black;
            color: white;
        }
        .head-section.show:hover{
            background-color: white;
            color: black;
            cursor: pointer;
        }

        .items{
            width: 200px;
            height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 1px solid black;
            text-align: center;
            transition: .3s all;
        }
        .items:hover{
            transition: .1s all;
            scale: 1.05;
        }
        .items:hover img{
            filter: brightness(80%);
        }
        .items img{
            width: 100%;
            height: 80%;
            object-fit: cover;
        }
        #user{
            width: 100%;
            height: 100%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            grid-template-rows: repeat(10, 100px);
            overflow-x: hidden;
            padding-top: 20px;
            padding-left: 20px;
        }



        #modal-popup{
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2;
            position: absolute;
            display: flex; 
            justify-content: center;
            align-items: center;
            visibility: hidden;
            opacity: 0;
            transition: .1s all;
        }
        #modal-popup.show{
            visibility: visible;
            opacity: 1;
            transition: .5s all;
        }
        .form{
            width: 50%;
            height: 80%;
            background-color: white;
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding-left: 20px;
        }
        .input{
            width: 300px;
            height: 30px;
        }
    </style>
</head>
<body>
    <div id="head">
        <div id="modal-popup">
            <div id="form-product" class="form">
                <form action="add_product_admin.php" method="post" enctype="multipart/form-data" style="gap: 10px; display: flex; flex-direction: column;">
                <div class="input-container">
                    <input type="text" name="product_name" class="input" id="product_name">
                    <label for="product_name">Product Name</label>
                </div>
                <div class="input-container">
                    <input type="text" name="product_price" class="input" id="product_price">
                    <label for="product_price">Product Price</label>
                </div>
                <div class="input-container">
                    <input type="text" name="product_type" class="input" id="product_type">
                    <label for="product_type">Product Type</label>
                </div>
                <div class="input-container">
                    <input type="text" name="product_describe" class="input" id="product_describe">
                    <label for="product_describe">Product Describe</label>
                </div>
                <div class="input-container">
                    <input type="text" name="product_size" class="input" id="product_size">
                    <label for="product_size">Product Size</label>
                </div>
                <div class="input-container" style="display: grid;">
                    <input type="file" name="product_img" id="product_img" hidden>
                    <label for="product_img" class="file-label">Select a product picture</label>

                    <input type="file" name="product_img1" id="product_img1" hidden>
                    <label for="product_img1" class="file-label">Select a product picture</label>

                    <input type="file" name="product_img2" id="product_img2" hidden>
                    <label for="product_img2" class="file-label">Select a product picture</label>

                    <input type="file" name="product_img3" id="product_img3" hidden>
                    <label for="product_img3" class="file-label">Select a product picture</label>
                </div>
                <input type="submit" value="ADD">
                </form>
            </div>
            <div id="form-vouncher" style="display: none;" class="form"></div>
        </div>
        <div id="header">
            <div id="head-label" onclick="window.location.href='../Pages/'">ADMIN</div>
            <div class="head-section" id="h-product">Product</div>
            <div class="head-section" id="h-user">User</div>
            <div class="head-section" id="h-vouncher">Vouncher</div>
            <div></div>
        </div>
        <div id="header-body">
            <div id="list">
                <div id="product" class="list-view">
                    <?php if(empty($product)): ?>
                        <span>Nothing in product table</span>
                    <?php else: ?>
                        <?php foreach($product as $p): ?>
                            <?php if($p['product_is_delete'] == 1): ?>
                                <div class="items" style="opacity: 0.7;">
                                    <span style="color: red; position: absolute; transform: rotateZ(40deg); font-size: 20px; z-index: 3;">Deleted</span>
                                    <img src="../picture-uploads/<?=$p['product_img']?>" alt="">
                                    <span><?=$p['product_name']?></span>
                                    <div style="width: 100%; display: flex; font-size: 13px; justify-content: space-around;">
                                        <form action="restore_item_admin.php" method="post">
                                            <input type="submit" id="p-restore-<?=$p['id']?>" hidden>
                                            <input type="hidden" name="id" value="<?=$p['id']?>">
                                            <label style="background-color: orangered; color: white;" for="p-restore-<?=$p['id']?>">Restore Product</label>
                                        </form>
                                        <form action="update_item_admin.php" method="post">
                                            <input type="submit" id="p-update" hidden>
                                            <label style="background-color: black; color: white;" for="p-update">Update Product</label>
                                        </form>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="items" style="opacity: 1;">
                                    <img src="../picture-uploads/<?=$p['product_img']?>" alt="">
                                    <span><?=$p['product_name']?></span>
                                    <div style="width: 100%; display: flex; font-size: 13px; justify-content: space-around;">
                                        <form action="delete_item_admin.php" method="post">
                                            <input type="submit" id="p-delete-<?=$p['id']?>" hidden>
                                            <input type="hidden" name="id" value="<?=$p['id']?>">
                                            <label style="background-color: orangered; color: white;" for="p-delete-<?=$p['id']?>">Delete Product</label>
                                        </form>
                                        <form action="update_item_admin.php" method="post">
                                            <input type="submit" id="p-update" hidden>
                                            <label style="background-color: black; color: white;" for="p-update">Update Product</label>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div id="user" style="display: none;">
                    <?php if(empty($userdata)): ?>
                        <span>Nothing in user table</span>
                    <?php else: ?>
                        <?php foreach($userdata as $u): ?>
                            <div class="items" style="width: 100px; 
                                                      height: 100px; display: 
                                                      flex; flex-direction: column; 
                                                      justify-content: center; 
                                                      align-items: center; 
                                                      border: 1px solid black; 
                                                      font-size: 10px; 
                                                      border: none;">
                                <img style="width: 60px; height: 60px; border-radius: 50%;" src="../upload/<?=$u['img']?>" alt="">
                                <span><?=$u['username']?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div id="vouncher" style="display: none" class="list-view">
                    <?php if(empty($vouncher)): ?>
                        <span>Nothing in vouncher table</span>
                    <?php else: ?>
                        <div class="items"></div>
                    <?php endif; ?>
                </div>
            </div>
            <div id="search">
                <div id="s-product" class="search-div">
                    <label id="total-products" style="text-align: center;"></label>
                    <input type="text" placeholder="Search" id="search-input-1">
                    <div id="add-product" style="text-align: center; 
                                                 background-color: orangered; 
                                                 color: white; width: 80%; 
                                                 height: 110%;">
                                Add new product
                    </div>
                </div>
                <div id="s-user" style="display: none;" class="search-div">
                    <label id="total-users" style="text-align: center;"></label>
                    <input type="text" placeholder="Search" id="search-input-2">
                </div>
                <div id="s-vouncher" style="display: none;" class="search-div">
                    <label id="total-vounchers" style="text-align: center;"></label>
                    <input type="text" placeholder="Search" id="search-input-3">
                    <div id="add-vouncher" style="text-align: center; 
                                                  background-color: orangered; 
                                                  color: white; 
                                                  width: 80%; 
                                                  height: 110%;">
                                Add new vouncher
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const h_product = document.getElementById("h-product");
        const product = document.getElementById("product");
        const section = document.querySelectorAll(".head-section");
        const lists = document.querySelectorAll(".list-view");
        const items = document.querySelectorAll(".items");
        const searchs = document.querySelectorAll(".search-div");
        const search_input_1 = document.getElementById("search-input-1");
        const search_input_2 = document.getElementById("search-input-2");
        const search_input_3 = document.getElementById("search-input-3");
        const add_product = document.getElementById("add-product");
        const add_vouncher = document.getElementById("add-vouncher");

        h_product.classList.add("show");
        product.style.display = "grid";

        section.forEach(sec =>{
            sec.addEventListener('click', ()=>{
                section.forEach(s => s.classList.remove("show"));
                lists.forEach(list => list.style.display = "none");
                searchs.forEach(search => search.style.display = "none");
                sec.classList.add("show");
                const name = sec.id.replace("h-", "");
                document.getElementById(name).style.display = "grid";
                document.getElementById("s-" + name).style.display = "grid";
            });
        });

        //SEARCH BY NAME FEAT
        search_input_1.addEventListener('keyup', ()=>{
            const keyword = search_input_1.value.toLowerCase();

            items.forEach(item =>{
                const search = item.textContent.toLowerCase();
                if(search.includes(keyword)){
                    item.style.display = "";
                }else{
                    item.style.display = "none";
                }
            });
        });
        search_input_2.addEventListener('keyup', ()=>{
            const keyword = search_input_2.value.toLowerCase();

            items.forEach(item =>{
                const search = item.textContent.toLowerCase();
                if(search.includes(keyword)){
                    item.style.display = "";
                }else{
                    item.style.display = "none";
                }
            });
        });
        search_input_3.addEventListener('keyup', ()=>{
            const keyword = search_input_3.value.toLowerCase();

            items.forEach(item =>{
                const search = item.textContent.toLowerCase();
                if(search.includes(keyword)){
                    item.style.display = "";
                }else{
                    item.style.display = "none";
                }
            });
        });
        //SEARCH BY NAME FEAT








        add_product.addEventListener('click', ()=>{
            console.log("a");
            document.getElementById("modal-popup").classList.add("show");
        });
        document.getElementById("modal-popup").addEventListener('click', (e)=>{
            const form = document.getElementById("form-product");
            if(!form.contains(e.target)){
                document.getElementById("modal-popup").classList.remove("show");
            }
        })


        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function () {
                const label = document.querySelector(`label[for="${this.id}"]`);
                if(this.files.length > 0) {
                    label.textContent = this.files[0].name;
                }else{
                    label.textContent = "Select a product picture";
                }
            });
        });




        const total_user = document.getElementById("total-users");
        const total_product = document.getElementById("total-products");
        const total_vouncher = document.getElementById("total-vounchers");

        const user = document.querySelectorAll("#user .items");
        const products = document.querySelectorAll("#product .items");
        const vouncher = document.querySelectorAll("#vouncher .items");

        total_user.textContent = "total users: " + user.length;
        total_product.textContent = "total products: " + products.length;
        total_vouncher.textContent = "total vounchers: " + vouncher.length;
    </script>
</body>
</html>