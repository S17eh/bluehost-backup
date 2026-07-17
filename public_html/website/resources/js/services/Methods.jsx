import axios from "axios";

export default {
    Fetch: function (method) {
        fetch(method).then(
            (res) => {
                return res.items;
            },
            (e) => {}
        );
    },

    /** Axios */
    // Get Method
    Get: async function (method) {
        const res = await axios.get(method);
        return res;
    },

    // Post Method
    Post: async function (method, param) {
        const res = await axios.post(method, param);
        return res;
    },

    // Error Exception
    Exception: function (e) {
        if (e.response) {
            if (e.response.status === 404) {
                e.response.data = {
                    responseMessage: "The specific request does not found.",
                };
            }
            return e.response;
        } else if (e.request) {
            return e.request;
        } else {
            return e.message;
        }
    },
};
