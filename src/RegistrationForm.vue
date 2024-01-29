<template>
  <div>
    <h2>Inscription</h2>
    <form @submit.prevent="registerUser">
      <label>Nom: <input v-model="name" required></label><br>
      <label>Email: <input v-model="email" type="email" required></label><br>
      <label>Mot de passe: <input v-model="password" type="password" @input="checkPassword" required></label><br>

      <div v-if="passwordStrengthMessages.length > 0">
        <p>Force du mot de passe :</p>
        <ul>
          <li v-for="message in passwordStrengthMessages" :key="message">{{ message }}</li>
        </ul>
      </div>

      <label>Numéro de téléphone: <input v-model="phone_number" type="tel" @input="checkPhoneNumber" required></label><br>

      <label>Information sur le véhicule:
        <select v-model="vehicle_information" required>
          <option value="vehicule">Véhiculé</option>
          <option value="permis">Permis</option>
          <option value="non_vehicule_permis">Non véhiculé ni permis</option>
        </select>
      </label><br>

      <button type="submit">S'inscrire</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      phone_number: '',
      vehicle_information: '',
      passwordStrengthMessages: [],
    };
  },
  methods: {
    checkPassword() {
      this.passwordStrengthMessages = [];
      // Vérification des conditions du mot de passe
      if (this.password.length < 8) {
        this.passwordStrengthMessages.push('Le mot de passe doit contenir au moins 8 caractères.');
      }
      if (!/[a-z]/.test(this.password)) {
        this.passwordStrengthMessages.push('Le mot de passe doit contenir au moins une lettre minuscule.');
      }
      if (!/[A-Z]/.test(this.password)) {
        this.passwordStrengthMessages.push('Le mot de passe doit contenir au moins une lettre majuscule.');
      }
      if (!/[0-9]/.test(this.password)) {
        this.passwordStrengthMessages.push('Le mot de passe doit contenir au moins un chiffre.');
      }
    },

    checkPhoneNumber() {
      // Limiter la longueur du numéro de téléphone à 10 chiffres
      if (this.phone_number.length > 10) {
        this.phone_number = this.phone_number.slice(0, 10);
      }

      // S'assurer que le champ n'accepte que des chiffres
      if (!/^\d*$/.test(this.phone_number)) {
        this.phone_number = this.phone_number.replace(/[^\d]/g, '');
      }
    },

    registerUser() {
      if (!this.name || !this.email || !this.password) {
        console.error('Veuillez remplir tous les champs obligatoires.');
        return;
      }

      fetch('http://localhost/gestion_inter_vue/api.php?action=register', {
        method: 'POST',
        body: new URLSearchParams({
          name: this.name,
          email: this.email,
          password: this.password,
          phone_number: this.phone_number,
          vehicle_information: this.vehicle_information,
        }),
      })
          .then(response => {
            if (response.ok) {
              console.log('Inscription réussie !');
              this.$router.push('/login');
            } else {
              console.error('Échec de l\'inscription. Code de statut :', response.status);
            }
          })
          .catch(error => {
            console.error('Erreur lors de la requête :', error);
          });
    },
  },
};
</script>
