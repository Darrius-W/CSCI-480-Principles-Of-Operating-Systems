CC = g++
CCFLAGS = -Wall -g

a1: a1.o
	$(CC) -o a1 $(CCFLAGS) $(INCLUDES) a1.o

a1.o: a1.cc
	$(CC) -c $(CCFLAGS) $(INCLUDES) a1.cc

clean:
	-rm *.o a1
