<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title></title>
    <link href="style.css" rel="stylesheet" />
  </head>
  <body class="bg-pasca">
    <section>
      <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto">
        <a
          href="#"
          class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"
        >
          <img class="h-28" src="../assets/ethol-logo.png" alt="logo" />
        </a>
        <div
          class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
        >
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1
              class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
            >
              Create an account
            </h1>
            <form class="space-y-4 md:space-y-6" action="" method="post">
              <div>
                <label
                  for="email"
                  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                  >Your email</label
                >
                <input
                  type="email"
                  name="email"
                  id="email"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="nama@gmail.com"
                  required=""
                />
              </div>
              <div>
                <label
                  for="password"
                  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                  >Password</label
                >
                <input
                  type="password"
                  name="password"
                  id="password"
                  placeholder="••••••••"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  required=""
                />
              </div>
              <div>
                <label
                  for="confirm-password"
                  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                  >Confirm password</label
                >
                <input
                  type="password"
                  name="confirm-password"
                  id="confirm-password"
                  placeholder="••••••••"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  required=""
                />
              </div>
              <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input
                    id="terms"
                    aria-describedby="terms"
                    type="checkbox"
                    class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800"
                    required=""
                  />
                </div>
                <div class="ml-3 text-sm">
                  <label
                    for="terms"
                    class="font-light text-gray-500 dark:text-gray-300"
                    >I accept the
                    <a
                      class="font-medium text-blue-600 hover:underline dark:text-blue-500"
                      href="#"
                      >Terms and Conditions</a
                    ></label
                  >
                </div>
              </div>
              <button
                type="submit"
name="submit"
                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              >
                Create an account
              </button>
              <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                Already have an account?
                <a
                  href="login.php"
                  class="font-medium text-blue-600 hover:underline dark:text-blue-500"
                  >Login here</a
                >
              </p>
            </form>
<?php 
include 'utils/conn.php';
if(isset($_POST["submit"])){
  $email = $_POST["email"];
  $password = md5($_POST["password"]);

  $sql = "INSERT INTO users (email, password, id_hak) VALUES ('$email', '$password', 3)";

if ($conn->query($sql) === TRUE) {
    echo '<div class="mt-5 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-700 dark:text-green-400" role="alert"><span class="font-medium">';
    echo 'Berhasil menambahkan user baru!';
    echo '</span></div>';
  } else {
    echo '<div class="mt-5 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-700 dark:text-green-400" role="alert"><span class="font-medium">';
    echo "Error: " . $sql . "<br>" . $conn->error;
    echo '</span></div>';
  }
}

?>
          </div>
        </div>
      </div>
    </section>
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
  </body>
</html>
