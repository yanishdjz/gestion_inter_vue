<template>
  <div>
    <h2>Connexion</h2>
    <form @submit.prevent="loginUser">
      <label>Email: <input v-model="email" type="email" required></label><br>
      <label>Mot de passe: <input v-model="password" type="password" required></label><br>
      <button type="submit">Se connecter</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    async loginUser() {
      try {
        const response = await fetch('http://localhost/gestion_inter_vue/api.php?action=login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        });

        const data = await response.json();

        if (data.success) {
          console.log('Utilisateur connecté:', data);
          localStorage.setItem('authToken', data.token);
          this.$router.push('/dashboard');
        } else {
          console.error('Échec de la connexion. Message d\'erreur:', data.message);
        }
      } catch (error) {
        console.error('Erreur lors de la connexion:', error);
      }
    },
  },
};
</script>
