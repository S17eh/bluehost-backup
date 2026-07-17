import {
    AboutUs,
    CurrentOpening,
    GeneratePDF,
    Home,
    SendApplyJobEmail,
    SendContactUsEmail,
    Services,
} from "./Constants";
import Methods from "./Methods";

export default {
    HomeData: async function () {
        try {
            const res = await Methods.Get(Home);
            return res;
        } catch (error) {
            return Methods.Exception(error);
        }
    },

    AboutUsData: async function () {
        try {
            const res = await Methods.Get(AboutUs);
            return res;
        } catch (error) {
            return Methods.Exception(error);
        }
    },
    
    ServicesData: async function () {
        try {
            const res = await Methods.Get(Services);
            return res;
        } catch (error) {
            return Methods.Exception(error);
        }
    },

    CurrentOpeningList: async function () {
        try {
            const res = await Methods.Get(CurrentOpening);
            return res;
        } catch (error) {
            return Methods.Exception(error);
        }
    },

    ContactUsEmail: async function (RequestValue) {
        try {
            const res = await Methods.Post(SendContactUsEmail, RequestValue);
            return res;
        } catch (error) {
            return Methods.Exception(error);
        }
    },

    ApplyJobEmail: async function (RequestValue) {
        try {
            const res = await Methods.Post(SendApplyJobEmail, RequestValue);
            return res;
        } catch (error) {
            return Methods.Exception(error);
        }
    },

    GenerateResume: async function (RequestValue) {
        try {
            const res = await Methods.Post(GeneratePDF, RequestValue);
            return res;
        } catch (error) {
            return Methods.Exception(error);
        }
    },
};
