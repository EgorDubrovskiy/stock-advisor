import React from 'react';

export default function Loading(props) {
  const classes = `spinner ${props.className || 'center'}`;
  return (
    <div className={classes}>
      <div className='spinner-blade'/>
      <div className='spinner-blade'/>
      <div className='spinner-blade'/>
      <div className='spinner-blade'/>
      <div className='spinner-blade'/>
      <div className='spinner-blade'/>
      <div className='spinner-blade'/>
      <div className='spinner-blade'/>
      <div className='spinner-blade'/>
      <div className='spinner-blade'/>
      <div className='spinner-blade'/>
      <div className='spinner-blade'/>
    </div>
  );
}
