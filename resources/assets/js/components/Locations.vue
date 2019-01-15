<template>
    <tree
      :data="treeData"
      :options="treeOptions"
      ref="tree"
    />
</template>


<script>
export default {
        data: function () {
            return {
                treeData: 'getTreeData()',
                treeOptions:
                {
                   checkbox: true,
                   propertyNames:
                   {
                       text:'code',
                       children:'children'
                   }
                   
                }
            }
        },
        mounted: function () {
            this.buildtree();
        },
        methods: {
            onNodeSelected(node) {
                console.log(Node)
            },

            buildtree: function () {
                const tree = this.$refs.tree.tree
                var self = this;
                axios.get("../api/location")
                    .then(response => {
                        self.treeData = response.data;
                       
                console.log(self.treeData);
                new Promise(resolve => {
                const items = {}
                self.treeData.forEach(item => {
                    const { code } = item;

                if (false === (code in items)) {
                    items[code] = []
                }

                let treeItem = {
                    text: item.desInPosition ? `${item.code} ${item.desInPosition}` : item.code,
                    data: item
                }

                    items[code].push(treeItem)
                })

                let o = Object.keys(items).reduce((a, b) => {
                let children = items[b]
                let item

                if (children.length > 1) {
                    item = {
                    text: children[0].data.code,
                    data: Object.assign({}, children[0].data),
                    children
                    }
                } else {
                    item = children[0]
                    item.data
                }

                if (!item.data) {
                    item.data = {
                    type: children[0].data.type,
                    isRoot: true
                    }
                } else {
                    item.data.isRoot = true
                }

                a.push(item)

                return a
                }, [])

                resolve(o)
                })
                     
                let model = tree.parse(self.treeData);
                this.$set(this.$refs.tree, 'model', model);
                tree.setModel(model);
                })
            }
        },
    }

    function getTreeData() {
        return [ ]    
}
</script>