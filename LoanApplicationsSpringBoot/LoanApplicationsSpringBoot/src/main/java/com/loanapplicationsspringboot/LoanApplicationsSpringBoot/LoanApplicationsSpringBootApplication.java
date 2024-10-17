package com.loanapplicationsspringboot.LoanApplicationsSpringBoot;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@SpringBootApplication
public class LoanApplicationsSpringBootApplication {

	 @RequestMapping("/")
	 String hello(){
		return "Hello Spring";
	}

	public static void main(String[] args) {
		SpringApplication.run(LoanApplicationsSpringBootApplication.class, args);
	}

}
