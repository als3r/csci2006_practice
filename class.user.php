<?php
class User {

    /**
     * Array with roles
     */
    const ROLE_VISITOR  = 'visitor';
    const ROLE_CUSTOMER = 'customer';
    const ROLES = [
        self::ROLE_VISITOR,
        self::ROLE_CUSTOMER,
    ];

    /**
     * Array with roles
     */
    const DEFAULT_PAGE_BY_ROLES = [
        "visitor"  => PAGE_HOME,
        "customer" => PAGE_ACCOUNT,
    ];

    /**
     * Permissions
     */
    const PERMISSION_VIEW_HOME                   = "view-home";
    const PERMISSION_VIEW_ARTIST                 = "view-artist";
    const PERMISSION_VIEW_ARTWORK                = "view-artwork";
    const PERMISSION_VIEW_ABOUT                  = "view-about";
    const PERMISSION_VIEW_LOGIN                  = "view-login";
    const PERMISSION_VIEW_ACCOUNT                = "view-account";
    const PERMISSION_VIEW_ORDER_HISTORY          = "view-order-history";
    const PERMISSION_VIEW_WISHLIST               = "view-wishlist";
    const PERMISSION_VIEW_CART                   = "view-cart";

    const PERMISSION_UPDATE_WISHLIST_ADD_ITEM    = 'action-add-to-wishlist';
    const PERMISSION_UPDATE_WISHLIST_REMOVE_ITEM = 'action-remove-from-wishlist';
    const PERMISSION_UPDATE_CART_ADD_ITEM        = 'action-add-to-cart';
    const PERMISSION_UPDATE_CART_REMOVE_ITEM     = 'action-remove-from-cart';
    const PERMISSION_UPDATE_CART_QUANTITY        = 'action-update-quantity-cart';
    const PERMISSION_UPDATE_CART_ADDRESS         = 'action-update-address-cart';
    const PERMISSION_PLACE_ORDER                 = 'action-place-order';

    /**
     * Array with permission by roles
     */
    const PERMISSIONS = [
        "visitor" => [
            self::PERMISSION_VIEW_HOME,
            self::PERMISSION_VIEW_ARTIST,
            self::PERMISSION_VIEW_ARTWORK,
            self::PERMISSION_VIEW_ABOUT,
            self::PERMISSION_VIEW_LOGIN,
            self::PERMISSION_VIEW_CART,

            self::PERMISSION_UPDATE_CART_ADD_ITEM,
            self::PERMISSION_UPDATE_CART_REMOVE_ITEM,
            self::PERMISSION_UPDATE_CART_QUANTITY,
            self::PERMISSION_UPDATE_CART_ADDRESS,
        ],
        "customer" => [
            self::PERMISSION_VIEW_HOME,
            self::PERMISSION_VIEW_ARTIST,
            self::PERMISSION_VIEW_ARTWORK,
            self::PERMISSION_VIEW_ABOUT,
            self::PERMISSION_VIEW_LOGIN,
            self::PERMISSION_VIEW_ACCOUNT,
            self::PERMISSION_VIEW_ORDER_HISTORY,
            self::PERMISSION_VIEW_WISHLIST,
            self::PERMISSION_VIEW_CART,

            self::PERMISSION_UPDATE_WISHLIST_ADD_ITEM,
            self::PERMISSION_UPDATE_WISHLIST_REMOVE_ITEM,
            self::PERMISSION_UPDATE_CART_ADD_ITEM,
            self::PERMISSION_UPDATE_CART_REMOVE_ITEM,
            self::PERMISSION_UPDATE_CART_QUANTITY,
            self::PERMISSION_UPDATE_CART_ADDRESS,
            self::PERMISSION_PLACE_ORDER,
        ],
    ];

    /**
     * Checks if user is logged in
     *
     * @return bool
     */
    public static function isLoggedIn(){
        if(isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] === true){
            return true;
        }
        return false;
    }

    /**
    * Logs in as a visitor
    *
    * @return bool
    */
    public static function logInWithDefaultRole(){
        $_SESSION["is_logged_in"] = true;
        $_SESSION["role"]         = self::ROLE_VISITOR;
    }

    /**
     * Does user has a role
     *
     * @return bool
     */
    public static function hasRole(){
        if(isset($_SESSION["role"]) && in_array($_SESSION["role"], self::ROLES)){
            return true;
        }
        return false;
    }


    /**
     * Get user role
     * @return bool|string
     */
    public static function getUserRole(){
        if(self::isLoggedIn() && self::hasRole()){
            return $_SESSION["role"];
        }
        return false;
    }

    /**
     * Does user has permission
     *
     * @param string $permission
     * @return bool
     */
    public static function hasPermission($permission = ''){
        $role = self::getUserRole();
        if(!$role){
            return false;
        }
        if(in_array($permission, self::PERMISSIONS[$role])){
            return true;
        }
        return false;
    }

    /**
     * Get default page for a role
     *
     * @return string
     */
    public static function getDefaultPage(){
        if(self::isLoggedIn() && self::hasRole()){
            $role = self::getUserRole();
            if(isset(self::DEFAULT_PAGE_BY_ROLES[$role])){
                return self::DEFAULT_PAGE_BY_ROLES[$role];
            }
        }
        return PAGE_LOGIN;
    }

    /**
     * Clear session after logout
     * @return void
     */
    public static function clearSession(){
        unset($_SESSION["is_logged_in"]);
        unset($_SESSION["role"]);
        unset($_SESSION["user"]);
    }
}
