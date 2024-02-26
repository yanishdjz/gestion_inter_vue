<template>
  <div>
    <h2>Inscription</h2>
    <form @submit.prevent="registerUser">
      <!-- Champ Nom -->
      <label>Nom: <input v-model="name" required></label><br>

      <!-- Champ Email -->
      <label>Email: <input v-model="email" type="email" required></label><br>

      <!-- Champ Mot de passe -->
      <label>Mot de passe: <input v-model="password" type="password" @input="checkPassword" required></label><br>

      <!-- Affichage de la force du mot de passe -->
      <div v-if="passwordStrengthMessages.length > 0">
        <p>Force du mot de passe :</p>
        <ul>
          <li v-for="message in passwordStrengthMessages" :key="message">{{ message }}</li>
        </ul>
      </div>

      <!-- Champ Numéro de téléphone -->
      <label>Numéro de téléphone: <input v-model="phone_number" type="tel" @input="checkPhoneNumber" required></label><br>

      <!-- Sélection de l'Information sur le véhicule -->
      <label>Information sur le véhicule:
        <select v-model="vehicle_information" required>
          <option value="vehicule">Véhiculé</option>
          <option value="permis">Permis</option>
          <option value="non_vehicule_permis">Non véhiculé ni permis</option>
        </select>
      </label><br>

      <!-- Bouton d'inscription -->
      <button type="submit">S'inscrire</button>
    </form>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  setup() {
    const name = ref('');
    const email = ref('');
    const password = ref('');
    const phone_number = ref('');
    const vehicle_information = ref('');
    const passwordStrengthMessages = ref([]);

    const checkPassword = () => {
      // Réinitialisation des messages de force du mot de passe
      passwordStrengthMessages.value = [];

      // Vérification des conditions du mot de passe
      if (password.value.length < 8) {
        passwordStrengthMessages.value.push('Le mot de passe doit contenir au moins 8 caractères.');
      }
      if (!/[a-z]/.test(password.value)) {
        passwordStrengthMessages.value.push('Le mot de passe doit contenir au moins une lettre minuscule.');
      }
      if (!/[A-Z]/.test(password.value)) {
        passwordStrengthMessages.value.push('Le mot de passe doit contenir au moins une lettre majuscule.');
      }
      if (!/[0-9]/.test(password.value)) {
        passwordStrengthMessages.value.push('Le mot de passe doit contenir au moins un chiffre.');
      }

      // Ajoutez d'autres conditions au besoin...
    };

    const checkPhoneNumber = () => {
      // Limiter la longueur du numéro de téléphone à 10 chiffres
      if (phone_number.value.length > 10) {
        phone_number.value = phone_number.value.slice(0, 10);
      }

      // S'assurer que le champ n'accepte que des chiffres
      if (!/^\d*$/.test(phone_number.value)) {
        phone_number.value = phone_number.value.replace(/[^\d]/g, '');
      }
    };

    const registerUser = async () => {
      // Validation des champs obligatoires
      if (!name.value || !email.value || !password.value) {
        console.error('Veuillez remplir tous les champs obligatoires.');
        return;
      }

      // Utilisation de fetch pour enregistrer les données dans l'API
      try {
        const response = await fetch('http://localhost:8080/gestion_inter_vue_api/api.php?action=register', {
          method: 'POST',
          headers: {
            // Vous n'avez pas besoin de spécifier 'Content-Type' ici
            // Fetch détectera automatiquement le type de contenu
          },
          body: new URLSearchParams({
            name: name.value,
            email: email.value,
            password: password.value,
            phone_number: phone_number.value,
            vehicle_information: vehicle_information.value,
          }),
        });

        if (response.ok) {
          console.log('Inscription réussie !');
          // Redirection vers la page de connexion
          // this.$router.push('/login');
        } else {
          console.error('Échec de l\'inscription. Code de statut :', response.status);
        }
      } catch (error) {
        console.error('Erreur lors de la requête :', error);
      }
    };

    return {
      name,
      email,
      password,
      phone_number,
      vehicle_information,
      passwordStrengthMessages,
      checkPassword,
      checkPhoneNumber,
      registerUser,
    };
  },
};
</script>
