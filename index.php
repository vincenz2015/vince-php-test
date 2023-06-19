<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Minutes Calculator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@2.6.14/dist/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
</head>

<body class="p-6">
    <div id="app" class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold mb-4">Business Minutes Calculator</h1>
        <form @submit.prevent="calculateBusinessMinutes" class="mb-6">
            <div class="mb-4">
                <label for="startDateTime" class="block text-gray-700">Start DateTime</label>
                <input type="datetime-local" id="startDateTime" v-model="startDateTime" class="border-solid border-2 p-2 rounded-2xl border-gray-300 bg-gray-100 form-input">
            </div>

            <div class="mb-4">
                <label for="endDateTime" class="block text-gray-700">End DateTime</label>
                <input type="datetime-local" id="endDateTime" v-model="endDateTime" class="border-solid border-2 p-2 rounded-2xl border-gray-300 bg-gray-100 form-input">
            </div>

            <div class="mb-4">
                <label for="includeWeekends" class="flex items-center">
                    <input type="checkbox" id="includeWeekends" v-model="includeWeekends" class="form-checkbox">
                    <span class="ml-2 text-gray-700">Include Weekends</span>
                </label>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Calculate
            </button>
        </form>

        <div v-if="result" class="bg-gray-100 p-4 rounded">
            <p class="text-lg font-bold">Result:</p>
            <p>Number of business minutes: <b>{{ result }}</b></p>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    startDateTime: '',
                    endDateTime: '',
                    includeWeekends: false,
                    result: null
                };
            },
            methods: {
                calculateBusinessMinutes() {
                    const that = this;
                    axios.post('api.php', JSON.stringify({
                            startDateTime: this.startDateTime,
                            endDateTime: this.endDateTime,
                            includeWeekends: this.includeWeekends
                        }))
                        .then(function(response) {
                            that.result = response.data;
                        })
                        .catch(function(error) {
                            console.log(error);
                        })
                }
            }
        });
    </script>
</body>

</html>