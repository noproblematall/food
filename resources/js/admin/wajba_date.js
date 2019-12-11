
const app = new Vue({
    el: '#app',
    data() {
        return {
            attrs: [
                {
                    key: 'Available Dates',
                    highlight: {
                        backgroundColor: '#ff8080',
                        color: 'red',
                        // Other properties are available too, like `height` & `borderRadius`
                    },
                    dates: [
                        { start: new Date(2019, 9, 30), end: new Date(2019, 10, 5) },
                        new Date(2019, 10, 8),
                        { start: new Date(2019, 11, 8), span: 5 } // Span is number of days
                    ]
                }
            ],
        };
    },
    mounted() {

    },
    created() {
        
    },
    methods: {

    }
});