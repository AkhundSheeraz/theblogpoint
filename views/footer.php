<footer class="bg-dark">
    <h5>Copyright &copy; The Blog Point 2021</h5>
</footer>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#register').on('submit', (event) => {
        event.preventDefault();
        const form = $('#register');
        $.ajax({
            url: '/index.php',
            type: 'POST',
            data: form.serialize()
        }).done(res => {
            res = JSON.parse(res);
            const msg = $('#regmsg');
            if (res.status == true && !msg.hasClass('msgsuccess')) {
                msg.addClass('msgsuccess');
                msg.html(res.message);
                setTimeout(() => {
                    msg.removeClass('msgsuccess');
                    msg.empty();
                }, 3000);
                document.getElementById('register').reset();
            } else {
                if (res.number == 0 && !msg.hasClass('msgfail')) {
                    msg.addClass('msgfail');
                    msg.html(res.message);
                    setTimeout(() => {
                        msg.removeClass('msgfail');
                        msg.empty();
                    }, 3000);
                } else if (res.number == 1 && !msg.hasClass('msgfail')) {
                    msg.addClass('msgfail');
                    msg.html(res.message);
                    setTimeout(() => {
                        msg.removeClass('msgfail');
                        msg.empty();
                    }, 3000);
                }
            }
        })
    })

    $('#log-out').on('click', (event) => {
        event.preventDefault();
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: {
                status: true,
                message: 'destroy session'
            }
        }).done(res => {
            window.location.href = ("http://blogsite.test/index.php");
        })
    })

    $('#login').on('submit', (event) => {
        event.preventDefault();
        const form = $('#login');
        $.ajax({
            url: 'index.php',
            type: 'POST',
            data: form.serialize()
        }).done(res => {
            res = JSON.parse(res);
            if (res.status == true) {
                window.location.href = window.location.href;
            } else {
                const msg = $("#login_error");
                if (res.type == 1) {
                    msg.addClass('msgfail')
                    msg.html(res.message);
                    setTimeout(() => {
                        msg.removeClass('msgfail')
                        msg.empty();
                    }, 3000);
                } else {
                    msg.addClass('msgfail')
                    msg.html(res.message);
                    setTimeout(() => {
                        msg.removeClass('msgfail')
                        msg.empty();
                    }, 3000);
                }
            }
        })
    })

    $('#blogpost').on("submit", (event) => {
        event.preventDefault();
        const form = $('#blogpost');
        $.ajax({
            url: 'newblog.php',
            type: 'POST',
            data: form.serialize()
        }).done(res => {
            const dblog = $(".d-blogs");
            if (document.URL.includes("blog.php")) {
                dblog.append(res);
                const deletebtn = $('.delbtn');
                deletebtn.remove();
                $('#staticBackdrop').modal('hide');
            } else {
                if($(".d-blogs").children(".blog").length == 0){
                    $(".noblog").remove();
                }
                dblog.append(res);
                $('#staticBackdrop').modal('hide');
            }
        })
    })

    $('#createblog').on('click', () => {
        const form = $('#blogpost');
        const bheading = $('#bloghead');
        if (form.hasClass('hide') && bheading.hasClass('msgsuccess')) {
            form.removeClass('hide');
            bheading.removeClass('msgsuccess');
            bheading.addClass('text-white');
            const head = $('#staticBackdropLabel');
            head.html('Add Blog');
        }
    })

    $('.d-blogs').on('click','.delbtn', function(event) { // "this" <- keyword only work with simple function not an arrow function
        event.preventDefault();
        const blogno = $(this).data('id');
        const parent = $(this).parent();
        const gparent = parent.parent();
        $.ajax({
            url: 'myblogs.php',
            type: 'POST',
            data: {
                id: blogno
            }
        }).done(res => {
            res = JSON.parse(res);
            if (res.status == true) {
                gparent.remove();
                if($(".d-blogs").children(".blog").length == 0){
                    $(".d-blogs").html("<h2 class='noblog text-white'>You have no Blogs</h2>");
                }
            }
        });
    })

    $(".dropdwn").on('click', function() {
        const dropdown = $(".d-down");
        dropdown.toggle("d-none");
    })

    $("#upload-form").on("submit", (event) => {
        event.preventDefault();
        let file = new FormData();
        file.append('filename', $("#userdp").prop('files')[0]);
        $.ajax({
            type: "POST",
            url: "profile.php",
            processData: false,
            contentType: false,
            data: file
        }).done(res => {
            res = JSON.parse(res);
            if (res.status == true) {
                $("#profilepic").attr("src", res.message);
            } else {
                const err = $(".error");
                err.html(res.message);
                setTimeout(() => {
                    err.empty();
                }, 3000);
            }
        })
    })

    $("#forgotcode").on("click", () => {
        const thismail = $("input[name=username]").val();
        const objdata = {
            mail: thismail,
            process: "code forget"
        };
        if (thismail.length > 0) {
            $.ajax({
                type: "POST",
                url: "index.php",
                data: objdata
            }).done(res => {
                res = JSON.parse(res);
                if (res.status == true) {
                    const msg = $("#login_error");
                    msg.addClass('msgsuccess')
                    msg.html(res.message);
                    setTimeout(() => {
                        msg.removeClass('msgsuccess')
                        msg.empty();
                    }, 3000);
                    document.getElementById('login').reset();
                };
            })
        } else {
            const thismail = $("input[name=username]")
            thismail.addClass("phwarn");
            thismail.attr("placeholder", "Email Required!");
            setTimeout(() => {
                thismail.attr("placeholder", "E-mail");
                thismail.removeClass("phwarn");
            }, 3000);
        }
    })

    $("#remove-dp").on("click", (event) => {
        event.preventDefault();
        const getpath = $("#profilepic").attr("src");
        $.ajax({
            type: "DELETE",
            url: "profile.php",
            data: getpath
        }).done(res => {
            res = JSON.parse(res);
            if (res.status == true) {
                $("#profilepic").attr("src", res.message);
            } else {
                const err = $(".error");
                err.html(res.message);
                setTimeout(() => {
                    err.empty();
                }, 3000);
            }
        });
    });

    $("#resetcode").on("submit", (event) => {
        event.preventDefault();
        const resetermail = $(".setmail").text()
        const obj = {
            headmail: resetermail
        }
        const form = $("#resetcode")
        const data = form.serialize() + '&' + $.param(obj);
        $.ajax({
            type: "POST",
            url: "forgetpass.php",
            data: data
        }).done(res => {
            res = JSON.parse(res);
            const codemsg = $("#codechangemsg");
            if(res.type == true){
                codemsg.addClass("msgsuccess");
                codemsg.html(res.message);
                setTimeout(()=>{
                    codemsg.removeClass("msgsuccess");
                    codemsg.empty();
                },3000);
                document.getElementById("resetcode").reset();
            }else{
                codemsg.addClass("msgfail");
                codemsg.html(res.message);
                setTimeout(()=>{
                    codemsg.removeClass("msgfail");
                    codemsg.empty();
                },3000);
            }
        });
    });

    function activation(msghere) {
        $(document).ready(function() {
            $('#exampleModal1').modal('show');
            const msg = $('#login_error');
            if(msghere.type == true){
                msg.addClass('msgsuccess');
                msg.html(msghere.msg);
                setTimeout(() => {
                    msg.removeClass('msgsuccess');
                    msg.empty();
                }, 4000);
            }else{
                msg.addClass('msgfail');
                msg.html(msghere.msg);
                setTimeout(() => {
                    msg.removeClass('msgfail');
                    msg.empty();
                }, 4000);
            }
        })
    }
</script>