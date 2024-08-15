<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Форма на Ajax</title>
</head>
<body>
    <div class="block center">
        <form action="index.php" class="center" method="POST">
            <span id="country" class="center"> </span>
            <input id="phoneNum" type="tel" name="number" placeholder="Введите номер телефона" onkeyup="showCountry(this.value);">
        </form>
    </div>

    <script>
        async function showCountry(str) {
            if (str.length === 0) {
                document.getElementById("country").innerHTML = "";
                return;
            }
            try {
                const response = await fetch('getCountry.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'q=' + encodeURIComponent(str)
                });

                if (response.ok) {
                    const data = await response.text();
                    document.getElementById("country").innerHTML = data;
                } else {
                    document.getElementById("country").innerHTML = "Ошибка сервера: " + response.status;
                }
            } catch (error) {
                document.getElementById("country").innerHTML = "Ошибка сети: " + error.message;
            }
        }
    </script>
</body>
</html>
