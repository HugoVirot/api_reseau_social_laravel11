<template>
  <div v-if="content !== ''">
    <div class="pt-2 text-center">
      <i class="mt-2 mx-auto fa-5x fa-solid fa-pen"></i>
      <h2 class="mt-2 fs-1">Modifier un message</h2>
    </div>

    <div class="container-fluid p-3 p-lg-5">
      <ValidationErrors
        :errors="validationErrors"
        v-if="validationErrors.length !== 0"
      />
      <div class="row justify-content-center p-2">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header text-center fs-5">
              changez les informations souhaitées
            </div>

            <div class="card-body p-5">
              <form @submit.prevent="editPost">
                <!-- image actuelle -->
                <div v-if="image" class="form-group row m-2 mb-4">
                  <div class="col-md-3">
                    <p>image actuelle</p>
                  </div>
                  <div class="col-md-9">
                    <img :src="`/images/${image}`" class="w-75" />
                  </div>
                </div>

                <!-- image du message -->
                <div class="form-group row m-2">
                  <label
                    for="image"
                    class="col-md-4 col-form-label text-md-right"
                    ><span v-if="image">modifier l'image</span
                    ><span v-else>ajouter une image</span></label
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
                      name="content"
                      required
                      autocomplete="content"
                    ></textarea>
                  </div>
                </div>

                <!-- tags du message -->
                <div class="form-group row m-2">
                  <label
                    for="tags"
                    class="col-md-4 col-form-label text-md-right"
                    >tags</label
                  >
                  <div class="col-md-6">
                    <input
                      v-model="tags"
                      id="tags"
                      type="text"
                      class="form-control text-dark"
                      name="tags"
                      required
                      autocomplete="tags"
                    />
                  </div>
                </div>

                <div class="form-group row mt-3 text-center">
                  <div class="col-md-6 offset-md-3 mt-3">
                    <button type="submit">Valider</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import ValidationErrors from "./ValidationErrors.vue";
import { useRouter } from "vue-router";
import { ref } from "vue";
import { useRoute } from "vue-router";
import { onBeforeMount } from "vue";

const route = useRoute();
const router = useRouter();

const content = ref("");
const tags = ref("");
const image = ref("");
const formData = new FormData();

const postId = route.params.id;
const validationErrors = ref([]);

// permet de placer une image dans formData dès qu'elle est sélectionnée
const onChange = (e) => {
  let chosenImage = e.target.files[0];
  formData.append("image", chosenImage);
};

const editPost = async () => {
  // on ajoute les données saisies au formData (l'image y est déjà)
  formData.append("content", content.value);
  formData.append("tags", tags.value);
  formData.append("_method", "PUT");

  // on envoie tout cela vers l'api via un appel axios
  await axios
    .post("/api/posts/" + postId, formData)
    .then((response) => {
      console.log(response);
      alert("Message modifié avec succès !");
      router.push("/");
    })
    .catch((error) => {
      if (error.response.status == "403") {
        alert("Vous n'avez pas l'autorisation de modifier ce message !");
        router.push("/");
      } else {
        validationErrors.value = error.response.data.errors;
      }
    });
};

onBeforeMount(() => {
  axios
    .get("http://localhost:8000/api/posts/" + postId)

    .then((response) => {
      console.log(response.data);
      content.value = response.data.post.content;
      tags.value = response.data.post.tags;
      image.value = response.data.post.image;
    })
    .catch((error) => console.log(error.response));
});
</script>

<style lang="scss">
@import "../../sass/style.scss";

i {
  color: $mainColor;
}
</style>