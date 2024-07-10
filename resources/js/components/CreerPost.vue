<template>
  <div v-if="!userStore.userLoggedIn" class="text-center fs-5">
    <p>connectez-vous pour poster un message</p>
    <RouterLink to="connexion"><button>connexion</button></RouterLink>
  </div>

  <div v-else class="container-fluid p-2 p-lg-3 mt-2">
    <ValidationErrors :errors="validationErrors" v-if="validationErrors" />
    <div class="row justify-content-center p-2">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center fs-5">
            <h2 class="mt-2 fs-3">Poster un message</h2>
          </div>

          <div class="card-body p-5 fs-5">
            <form @submit.prevent="sendPost">
              <!-- image du message -->
              <div class="form-group row m-2">
                <label for="image" class="col-md-4 col-form-label text-md-right"
                  ><span> image</span></label
                >
                <div class="col-md-6">
                  <input
                    id="image"
                    type="file"
                    class="form-control text-dark"
                    name="image"
                    v-on:change="onChange"
                  />
                </div>
              </div>

              <!-- contenu du message -->
              <div class="form-group row m-2">
                <label
                  for="content"
                  class="col-md-4 col-form-label text-md-right"
                  >texte</label
                >
                <div class="col-md-6">
                  <textarea
                    v-model="content"
                    id="content"
                    type="text"
                    class="form-control"
                    placeholder="Bonjour tout le monde !"
                    name="content"
                    required
                    autocomplete="content"
                  ></textarea>
                </div>
              </div>

              <!-- tags du message -->
              <div class="form-group row m-2">
                <label for="tags" class="col-md-4 col-form-label text-md-right"
                  >tags</label
                >
                <div class="col-md-6">
                  <input
                    v-model="tags"
                    id="tags"
                    type="text"
                    class="form-control text-dark"
                    name="tags"
                    placeholder="bonjour"
                    required
                    autocomplete="tags"
                  />
                </div>
              </div>

              <div class="form-group row mt-3 text-center">
                <div class="col-md-6 offset-md-3">
                  <button type="submit" class="">Valider</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import ValidationErrors from "./ValidationErrors.vue";
import { useUserStore } from "../stores/userStore";
import { ref } from "vue";
import { RouterLink } from "vue-router";
import { useRouter } from "vue-router";
const router = useRouter();

const content = ref("");
const tags = ref("");
const validationErrors = ref("");
const formData = new FormData();

const userStore = useUserStore();

// permet de placer une image dans formData dès qu'elle est sélectionnée
const onChange = (e) => {
  let chosenImage = e.target.files[0];
  formData.append("image", chosenImage);
};

const sendPost = async () => {
  // on ajoute les données saisies au formData (l'image y est déjà)
  formData.append("content", content.value);
  formData.append("tags", tags.value);
  formData.append("user_id", userStore.id);

  // on envoie tout cela vers l'api via un appel axios
  await axios
    .post("/api/posts", formData)
    .then((response) => {
      alert("Message créé avec succès !");
      router.go(0); // force la page à se recharger pour récupérer la nouvelle liste des posts
    })
    .catch((error) => {
      validationErrors.value = error.response.data.errors;
    });
};
</script>