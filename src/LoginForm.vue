<template>
  <div>
    <h2>Connexion</h2>
    <form @submit.prevent="loginUser">
      <!-- Vos champs de formulaire (email, mot de passe, etc.) -->
      <label>Email: <input v-model="email" type="email" required></label><br>
      <label>Mot de passe: <input v-model="password" type="password" required></label><br>

      <button type="submit">Se connecter</button>
    </form>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  setup() {
    const email = ref('');
    const password = ref('');

    const loginUser = async () => {
      try {
        const response = await fetch('http://localhost:8080/gestion_inter_vue_api/api.php?action=login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            email: email.value,
            password: password.value,
            // Autres champs...
          }),
        });

        if (response.ok) {
          const data = await response.json();
          // Gestion de la réponse de votre API après la connexion
          if (data.success) {
            // Connexion réussie, vous pouvez stocker le jeton d'authentification dans un cookie ou local storage
            console.log('Utilisateur connecté:', data);

            // Stockage du jeton dans le local storage
            localStorage.setItem('authToken', data.token);

            // Redirection vers une page sécurisée ou tableau de bord, par exemple
            // this.$router.push('/dashboard');
          } else {
            // Connexion échouée, affichez un message d'erreur ou prenez d'autres mesures nécessaires
            console.error('Échec de la connexion. Message d\'erreur:', data.message);
          }
        } else {
          console.error('Échec de la requête. Code de statut:', response.status);
        }
      } catch (error) {
        // Gestion des erreurs lors de la requête
        console.error('Erreur lors de la connexion:', error);
      }
    };

    return {
      email,
      password,
      loginUser,
    };
  },
};
</script>
