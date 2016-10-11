var signupApp = new Vue({
    el: '#app',
    data: {
        departments: '',
        selected_department: '',
        groups: '',
        selected_group: ''

    },

    created: function () {

    },

    ready: function () {
        this.fetchDepartments();
    },

    methods: {
        fetchDepartments: function () {
            this.$http.get(newYlg.fetchDepartmentsRoute).then(function (res) {
                this.departments = res.data;
            }, function () {
                console.log('Failed to fetch departments')
            });
        },
        fetchGroups: function () {
            this.$http.get(Attendize.fetchGroupsRoute + '/' + this.selected_department).then(function (res) {
                this.groups = res.data;
            }, function () {
                console.log('Failed to fetch groups')
            });
        }

    }
});
