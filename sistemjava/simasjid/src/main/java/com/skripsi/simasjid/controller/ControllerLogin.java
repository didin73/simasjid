package com.skripsi.simasjid.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

@Controller
public class ControllerLogin {

    @RequestMapping(value = "/cekUser", method = RequestMethod.POST)
    public String cekUser(){
        return "redirect:/";
    }

    @RequestMapping("/logout")
    public String logout(){
        return "redirect:/login";
    }

}