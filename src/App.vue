<template>
  <div>
    <router-link to="/">Accueil</router-link>
    <router-link to="/login">Login</router-link>
    <router-link to="/register">Register</router-link>
    <router-view></router-view>
  </div>
</template>

<script>

</script>>

<style>
form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  background-color: #fff;
}

h2 {
  text-align: center;
  color: #333;
}

label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}

input {
  width: 100%;
  padding: 8px;
  margin-bottom: 15px;
  box-sizing: border-box;
  border: 1px solid #ccc;
  border-radius: 3px;
}

button {
  background-color: #4caf50;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}

/* Styles spécifiques pour le formulaire de connexion */
#app > div[data-v-xxxxxxx] {
  text-align: center;
}

/* Styles spécifiques pour le formulaire d'inscription */
#app > div[data-v-yyyyyyy] {
  text-align: center;
}

/* Lien vers l'autre formulaire */
router-link {
  display: block;
  margin-top: 15px;
  color: #333;
  text-decoration: none;
}

router-link:hover {
  text-decoration: underline;
}
</style>
