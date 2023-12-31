// Vue libraries
require("./bootstrap");
import { createApp } from "vue";
import { Form } from "vform";
import swal from "sweetalert2";
import "sweetalert2/src/sweetalert2.scss";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';


window.Vue = require("vue");

import PrimeVue from "primevue/config";
import "primevue/resources/themes/saga-blue/theme.css"; //theme
import "primevue/resources/primevue.min.css"; //core css
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import Card from 'primevue/card';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import Listbox from 'primevue/listbox';
import Fieldset from 'primevue/fieldset';
import Panel from 'primevue/panel';
import Dialog from 'primevue/dialog';
import Image from 'primevue/image';



import UsersComponent from "./components/UsersComponent.vue";
import MailingListComponent from "./components/MailingListComponent.vue";
import FeedbackComponent from "./components/FeedbackComponent.vue";
import PaymentComponent from "./components/PaymentComponent.vue";
import DonationComponent from "./components/DonationComponent.vue";
import ProfileComponent from "./components/ProfileComponent.vue";
import DashboardComponent from "./components/DashboardComponent.vue";
import ExampleComponent from './components/ExampleComponent.vue';
import AllahNamesComponent from './components/AllahNamesComponent.vue';
import HomepageComponent from './components/HomepageComponent.vue';
import PricingComponent from './components/PricingComponent.vue';
import ContactComponent from './components/ContactComponent.vue';
import ReminderComponent from './components/ReminderComponent.vue';
import CharityComponent from './components/CharityComponent.vue';
import VolunteerComponent from './components/VolunteerComponent.vue';
import AhadithComponent from './components/AhadithComponent.vue';
import HadithNawawiComponent from './components/HadithNawawiComponent.vue';
import HadithQudsiComponent from './components/HadithQudsiComponent.vue';
import HadithShahComponent from './components/HadithShahComponent.vue';
import VideoComponent from './components/VideoComponent.vue';
import KnowledgeComponent from './components/KnowledgeComponent.vue';
import CorrectionComponent from './components/CorrectionComponent.vue';
import LikesComponent from './components/LikesComponent.vue';
import ProphetsComponent from './components/ProphetsComponent.vue';
import QuranComponent from './components/QuranComponent.vue';


window.Vue = require('vue');

const app = createApp({});

window.Form = Form;
window.Swal = swal;

app.use(PrimeVue);
app.component('pagination', require('laravel-vue-pagination'));


app.component("Column", Column);
app.component("DataTable", DataTable);
app.component("Button", Button);
app.component("InputText", InputText);
app.component("AccordionTab", AccordionTab);
app.component("Accordion", Accordion);
app.component("Card", Card);
app.component("TabView", TabView);
app.component("TabPanel", TabPanel);
app.component("ListBox", Listbox);
app.component("Fieldset", Fieldset);
app.component("Panel", Panel);
app.component("Dialog", Dialog);
app.component("Image", Image);


app.component("example-component", ExampleComponent);
app.component("users-component", UsersComponent);
app.component("mailing_list-component", MailingListComponent);
app.component("feedback-component", FeedbackComponent);
app.component("payment-component", PaymentComponent);
app.component("donation-component", DonationComponent);
app.component("profile-component", ProfileComponent);
app.component("dashboard-component", DashboardComponent);
app.component("allah_names-component", AllahNamesComponent);
app.component("homepage-component", HomepageComponent);
app.component("pricing-component", PricingComponent);
app.component("contact-component", ContactComponent);
app.component("reminder-component", ReminderComponent);
app.component("charity-component", CharityComponent);
app.component("volunteer-component", VolunteerComponent);
app.component("ahadith-component", AhadithComponent);
app.component("hadith_nawawi-component", HadithNawawiComponent);
app.component("hadith_qudsi-component", HadithQudsiComponent);
app.component("hadith_shah-component", HadithShahComponent);
app.component("video-component", VideoComponent);
app.component("knowledge-component", KnowledgeComponent);
app.component("correction-component", CorrectionComponent);
app.component("likes-component", LikesComponent);
app.component("prophets-component", ProphetsComponent);
app.component("quran-component", QuranComponent);


app.mount('#app');
