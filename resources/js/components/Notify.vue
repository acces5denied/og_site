<template>
        <li class="notifications dropdown">
                <span class="counter bgc-red">3</span> 
                <a href="" class="dropdown-toggle no-after" data-toggle="dropdown"><i class="ti-bell"></i></a>
                <ul class="dropdown-menu">
                    <li class="pX-20 pY-15 bdB">
                        <i class="ti-bell pR-10"></i> 
                        <span class="fsz-sm fw-600 c-grey-900">Новые заявки</span>
                    </li>
                    <li>
                        <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                        
                            <li v-for="notification in notifications">
                            
                                <a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                                {{ JSON.parse(notification.data).banner.id}}
                                    <div class="peer mR-15"><img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/1.jpg" alt=""></div>
                                    <div class="peer peer-greed"><span><span class="fw-500">John Doe</span> <span class="c-grey-600">liked your <span class="text-dark">post</span></span>
                                        </span>
                                        <p class="m-0"><small class="fsz-xs">5 mins ago</small></p>
                                    </div>
                                </a>
                            </li>
                            
                        </ul>
                    </li>
                </ul>
            </li>
</template>
            

<script>
    export default {
         props: ['notifications']
    }
</script>