<template>
  <div class="p-3">
    <i class="fa-solid fa-3x fa-user-check"></i>
    <h1 class="mt-2">Mon Compte</h1>
  </div>

  <div class="container-fluid px-3 p-lg-4">
    <!-- composant affichant les erreurs de validation des formulaires -->
    <ValidationErrors :errors="validationErrors" v-if="validationErrors" />

    <div class="row justify-content-center px-2 p-lg-4">
      <p class="mx-auto mb-5">
        Bienvenue, {{ userStore.pseudo }} !
      </p>
      <div class="col-md-8 p-1">
        <div class="card">
          <div class="card-header mb-3 fs-5">Modifier mes infos</div>

          <form @submit.prevent="sendData">
            <div class="card-body">
              <div class="form-group row m-2">
                <label for="email" class="col-md-4 col-form-label text-md-right"
                  >e-mail</label
                >

                <div class="col-md-6">
                  <input
                    v-model="userStore.email"
                    id="email"
                    type="email"
                    class="form-control"
                    name="email"
                    autocomplete="email"
                  />
                </div>
              </div>

              <div class="form-group row mt-3 text-center">
                <div class="col-md-6 offset-md-3">
                  <button id="boutonValider" type="submit">Valider</button>
                </div>
              </div>
            </div>

            <div class="card-header mt-3 mb-1 fs-5">
              Modifier le mot de passe
            </div>

            <div class="card-body">
              <div id="infosMdp" class="form-group row">
                <div
                  id="passwordHelpBlock"
                  class="mx-auto p-2 m-2 border border-info"
                >
                  Votre mot de passe doit comporter au moins 8 caractères. Il
                  contenir au moins une lettre, un chiffre, une minuscule, une
                  majuscule et un caractère spécial.
                </div>
              </div>

              <div class="form-group row m-2">
                <label
                  for="oldPassword"
                  class="col-md-4 col-form-label text-md-right"
                  >mot de passe actuel</label
                >

                <div class="col-md-6">
                  <input
                    v-model="oldPassword"
                    id="oldPassword"
                    type="password"
                    class="form-control"
                    name="oldPassword"
                  />
                </div>
              </div>

              <div class="form-group row m-2">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                  >nouveau mot de passe</label
                >

                <div class="col-md-6">
                  <input
                    v-model="password"
                    @keyup="checkPassword(password)"
                    id="password"
                    type="password"
                    class="form-control"
                    name="password"
                  />
                </div>
              </div>

              <div
                v-if="passwordTyped"
                class="container"
                id="dynamicPasswordCheck"
              >
                <div class="row">
                  <p>
                    minimum 8 caractères
                    <i
                      v-if="eightCharacters"
                      class="p-2 bg-white rounded-circle greenIcon fa-solid fa-check"
                    ></i>
                    <i
                      v-else
                      class="p-2 bg-white rounded-circle fa-solid fa-xmark"
                    ></i>
                  </p>
                </div>

                <div class="row">
                  <p>
                    minimum 1 lettre
                    <i
                      v-if="oneLetter"
                      class="p-2 bg-white rounded-circle greenIcon fa-solid fa-check"
                    ></i>
                    <i
                      v-else
                      class="p-2 bg-white rounded-circle fa-solid fa-xmark"
                    ></i>
                  </p>
                </div>

                <div class="row">
                  <p>
                    minimum 1 chiffre
                    <i
                      v-if="oneDigit"
                      class="p-2 bg-white rounded-circle greenIcon fa-solid fa-check"
                    ></i>
                    <i
                      v-else
                      class="p-2 bg-white rounded-circle fa-solid fa-xmark"
                    ></i>
                  </p>
                </div>

                <div class="row">
                  <p>
                    minimum 1 majuscule et 1 minuscule
                    <i
                      v-if="oneUppercaseOneLowercase"
                      class="p-2 bg-white rounded-circle greenIcon fa-solid fa-check"
                    ></i>
                    <i
                      v-else
                      class="p-2 bg-white rounded-circle fa-solid fa-xmark"
                    ></i>
                  </p>
                </div>

                <div class="row">
                  <p>
                    minimum 1 caractère spécial
                    <i
                      v-if="oneSpecialCharacter"
                      class="p-2 bg-white rounded-circle greenIcon fa-solid fa-check"
                    ></i>
                    <i
                      v-else
                      class="p-2 bg-white rounded-circle fa-solid fa-xmark"
                    ></i>
                  </p>
                </div>
              </div>
            </div>

            <div
              v-if="passwordCorrect == true && password.length != 0"
              class="form-group row mx-auto text-center greenBackground rounded mt-2 mb-4 w-50"
            >
              <i class="fa-solid fa-circle-check fa-3x p-2 mb-2"></i>
              <p class="titleIcon fs-5">Mot de passe sécurisé</p>
            </div>

            <div class="form-group row m-2">
              <label
                for="password_confirmation"
                class="col-md-4 col-form-label text-md-right"
                >confirmez le mot de passe</label
              >

              <div class="col-md-6">
                <input
                  v-model="password_confirmation"
                  id="password_confirmation"
                  type="password"
                  class="form-control"
                  name="password_confirmation"
                />
              </div>
            </div>

            <div
              v-if="
                passwordCorrect &&
                password.length != 0 &&
                password == password_confirmation
              "
              class="form-group row mx-auto text-center greenBackground rounded mt-3 mb-4 w-50"
            >
              <i class="fa-solid fa-circle-check fa-3x p-2 mb-2"></i>
              <p class="titleIcon fs-5">Confirmation OK</p>
            </div>

            <div class="form-group row m-3 text-center">
              <div class="col-md-6 offset-md-3">
                <button id="boutonValider" type="submit">Valider</button>
              </div>
            </div>
          </form>
        </div>

        <div class="card">
          <div class="card-header mb-3 fs-5">Supprimer mon compte</div>

          <form @submit.prevent="deleteAccount">
            <div class="card-body">
              <i
                class="fa-solid fa-triangle-exclamation fa-5x text-danger mb-2"
              ></i>

              <p>
                Attention : cette action est irréversible.
              </p>

              <div class="form-group row m-3 text-center">
                <div class="col-md-6 offset-md-3">
                  <button
                    type="submit"
                    class="btn rounded-pill text-light btn-danger"
                  >
                    Supprimer mon compte
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import ValidationErrors from "./ValidationErrors.vue";
import { useUserStore } from "../stores/userStore";
import { useRouter } from "vue-router";
import { ref } from "vue";

const router = useRouter();

const userStore = useUserStore();

const oldPassword = ref("");
const password = ref("");
const password_confirmation = ref("");
const passwordTyped = ref(false);
const eightCharacters = ref(false);
const oneLetter = ref(false);
const oneUppercaseOneLowercase = ref(false);
const oneDigit = ref(false);
const oneSpecialCharacter = ref(false);
const passwordCorrect = ref(false);
const validationErrors = ref("");

// vérifier si le mot de passe réunit les critères de sécurité

const checkPassword = (password) => {
  passwordTyped.value = true;
  passwordCorrect.value = false;

  password.length >= 8
    ? (eightCharacters.value = true)
    : (eightCharacters.value = false);
  password.match(/[a-z]/)
    ? (oneLetter.value = true)
    : (oneLetter.value = false);
  password.match(/(?=.*[a-z])(?=.*[A-Z])/)
    ? (oneUppercaseOneLowercase.value = true)
    : (oneUppercaseOneLowercase.value = false);
  password.match(/\d/) ? (oneDigit.value = true) : (oneDigit.value = false);
  password.match(/[!@#$%^&*?]/)
    ? (oneSpecialCharacter.value = true)
    : (oneSpecialCharacter.value = false);

  if (
    eightCharacters.value &&
    oneLetter.value &&
    oneUppercaseOneLowercase.value &&
    oneDigit.value &&
    oneSpecialCharacter.value
  ) {
    passwordCorrect.value = true;
  }
};

// on envoie les modifs pour les sauvegarder en bdd puis on redirige
const sendData = async () => {
  await axios
    .put("/api/users/" + userStore.id, {
      email: email.value,
      oldPassword: oldPassword.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    })
    .then((response) => {
      alert(response.data.message);
      router.push("/");
      userStore.storeUserData(response.data[0]);
    })
    .catch((error) => {
      if (error.response) {
        validationErrors.value = error.response.data.errors;
      }
    });
};

// suppression du compte utilisateur
const deleteAccount = async () => {
  await axios
    .delete("/api/users/" + userStore.id)
    .then((response) => {
      // suppression compte fonctionne (plus dans bdd) mais il ne se passe rien ensuite
      // => pas de déconnexion, mais le user n'existe plus. On reste connecté.
      // à corriger
      logOutUser();
      alert(response.data.message);
    })
    .catch(() => {
      // message d'erreur pour l'utilisateur en cas d'échec de l'appel API
      alert(
        "Une erreur s'est produite. Certains éléments peuvent ne pas être affichés. Vous pouvez essayer de recharger la page pour corriger le problème."
      );
    });
};

// déconnecter l'utilisateur (utilisé après la suppression de compte)
const logOutUser = () => {
  // on réinitialise le store
  userStore.$reset();
  // on redirige vers l'accueil
  router.push("/");
};
</script>

<style scoped lang="scss">
* {
  text-align: center;
}

.greenIcon {
  color: rgb(24, 165, 80) !important;
}

.greenBackground {
  background-color: rgb(64, 189, 72);
}

#passwordHelpBlock {
  max-width: 600px;
}

.fa-xmark {
  color: red;
}
</style>