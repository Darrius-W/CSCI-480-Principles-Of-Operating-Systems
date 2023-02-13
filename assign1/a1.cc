/********************************************************************
CSCI 480 - Assignment 1 - Fall/2022

Progammer: Darrius White(z1900146)
Section:   Y01
Date Due:  09/16/2022

Purpose:   Program is designed to create 2 forks which creates 4
	   different processes and to use system calls to organize
	   the process ids, show the relationships for each process,
	   and overall get more familiar with OS system calls.

*********************************************************************/

#include <unistd.h>
#include <stdlib.h>
#include <sys/wait.h>
#include <stdio.h>
#include <string.h>
#include <sys/types.h>
#include <iostream>
using namespace std;

int main(void)
{
pid_t pid1, pid2;


 int a = 10;

 int b = 200;


 printf("init: a = %d b = %d.\n ", a, b);


 if((pid1 = fork()) <0)

 {

   printf("fork error");

   exit(-1);

 }

 else if (pid1 == 0)

 {

   a = a + 10;

   printf("first: a = %d b = %d.\n ", a, b);

 }


 if((pid2 = fork()) < 0)

 {

   printf("fork error");

   exit(-1);

 }

else if (pid2 == 0 )

{

 a = a*2;

   b = b + 200;

   printf("second: a = %d b = %d.\n ", a, b);

}


  return 0;
}
