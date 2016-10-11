var editApp = new Vue({
    el: '#app',
    data: {
        departments: '',
        selected_department: Attendize.currentDepartment,
        groups: '',
        selected_group: Attendize.currentGroup

    },

    created: function () {
        this.fetchDepartments();
        console.log('created');
    },

    ready: function () {
        this.fetchDepartments();
        console.log('beforeCompile');
    },

    methods: {
        fetchDepartments: function () {
            this.$http.get(Attendize.fetchDepartmentsRoute).then(function (res) {
                this.departments = res.data;
                console.log(res);
            }, function () {
                console.log('Failed to fetch departments')
            });
        },
        fetchGroups: function () {
            console.log('hahah');
            this.$http.get(Attendize.fetchGroupsRoute + '/' + this.selected_department).then(function (res) {
                this.groups = res.data;
                jQuery.each(this.groups, function(value) {
                    console.log(value);
                })
            }, function () {
                console.log('Failed to fetch groups')
            });
        }

    }
});
